<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CampaignGeneratorService
{
    private string $apiKey;
    private string $model = 'claude-opus-4-6';

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.key', '');
    }

    // All supported personas with their messaging context
    public static function personaDefinitions(): array
    {
        return [
            'enterprise_automation' => [
                'label'    => 'Enterprise Automation Engineer',
                'group'    => 'Production Builders',
                'audience' => 'IT/Ops professionals building internal automation at scale. They care about reliability, governance, and making automation work across complex enterprise systems.',
                'emphasis' => 'Production reliability, scalability, enterprise governance, compliance requirements, metrics and observability, proven at scale.',
                'tone'     => 'Technical but practical. They want proof it works in production — not just demos.',
            ],
            'agent_architect' => [
                'label'    => 'Agent Systems Architect',
                'group'    => 'Production Builders',
                'audience' => 'AI/ML platform engineers building production multi-agent systems. They care deeply about safety, correctness, and whether the architecture holds up under real production conditions.',
                'emphasis' => 'Architectural correctness, safety at the API boundary, multi-agent coordination, idempotency, audit trails baked in, production-grade design patterns.',
                'tone'     => 'Highly technical. They will scrutinize the architecture. Lead with principles, not marketing.',
            ],
            'product_ai_builder' => [
                'label'    => 'Product-Facing AI Builder',
                'group'    => 'Production Builders',
                'audience' => 'Full-stack and product engineers shipping AI features to end customers. They care about shipping fast, keeping things clean, and not exposing their users to AI failures.',
                'emphasis' => 'Developer experience, shipping speed, clean abstractions, protecting end users from AI errors, time-to-ship, real examples.',
                'tone'     => 'Pragmatic. They want to get it done. Show examples. Keep it concrete.',
            ],
            'trust_risk' => [
                'label'    => 'Trust & Risk Steward',
                'group'    => 'Trust & Risk Stewards',
                'audience' => 'Security, compliance, legal, and risk professionals evaluating AI adoption. They care about auditability, explainability, regulatory compliance, and not getting burned.',
                'emphasis' => 'Auditability, governance artifacts, explainability, regulatory compliance, institutional safety, risk mitigation, nothing happens without a paper trail.',
                'tone'     => 'Formal and precise. Avoid hype. Lead with what can be verified and audited.',
            ],
            'ai_learner' => [
                'label'    => 'AI Learner & Accelerator',
                'group'    => 'AI Learners & Accelerators',
                'audience' => 'Business analysts, operations managers, and non-developer power users who want AI to make their work faster and smarter — without needing to understand the infrastructure.',
                'emphasis' => 'Empowerment, making you faster and smarter, easy wins, real templates and examples, "you can do this without being an engineer".',
                'tone'     => 'Inspiring and accessible. No jargon. Make them feel capable.',
            ],
        ];
    }

    public function generate(array $extracted, array $personas = []): array
    {
        $landingData = $this->generateLandingPage($extracted['text'], $extracted['title'] ?? '');

        // Default to enterprise_automation if no personas selected
        if (empty($personas)) {
            $personas = ['enterprise_automation'];
        }

        $allPackages = [];
        foreach ($personas as $personaKey) {
            $packages = $this->generatePackages($extracted['text'], $landingData, $personaKey);
            foreach ($packages as $pkg) {
                $pkg['persona'] = $personaKey;
                $allPackages[]  = $pkg;
            }
        }

        return [
            'landing'  => $landingData,
            'packages' => $allPackages,
        ];
    }

    private function generateLandingPage(string $content, string $sourceTitle): array
    {
        $prompt = <<<PROMPT
You are a developer marketing strategist at Workato. Given this source content, generate a structured landing page for a developer-facing campaign.

Source content:
{$content}

Return ONLY valid JSON with this exact structure (no markdown, no explanation):
{
  "title": "short page title",
  "hero_headline": "a bold, problem-statement headline (max 12 words) — like 'You're building agents faster than your governance can keep up'",
  "hero_subheadline": "1-2 sentences in plain language. No jargon. What this is and why it matters to a business audience.",
  "framework_name": "the name of the framework, concept, or product (e.g. 'The Seven Factors')",
  "framework_intro": "one sentence introducing the list below",
  "concepts": [
    {"number": "01", "name": "Concept Name", "principle": "Plain-language one-sentence description of this concept. No jargon."},
    {"number": "02", "name": "...", "principle": "..."}
  ],
  "context_headline": "a sentence positioning this in the broader landscape",
  "context_body": "2-3 sentences on why this matters — the 'so what' for a business decision-maker",
  "cta_headline": "a call to action headline (community / contribution / action)",
  "cta_body": "1-2 sentences explaining the ask"
}

Rules:
- 3-8 concepts
- All principle text should be readable by a non-developer (no 'probabilistic', 'idempotent', 'mutations', etc.)
- hero_headline should feel like a strong opinion, not a product description
PROMPT;

        $raw = $this->callClaude($prompt);
        $data = json_decode($raw, true);

        if (!$data) {
            // Try to extract JSON from response if Claude added surrounding text
            preg_match('/\{.*\}/s', $raw, $m);
            $data = json_decode($m[0] ?? '{}', true) ?? [];
        }

        return $data;
    }

    private function generatePackages(string $content, array $landingData, string $personaKey): array
    {
        $frameworkName = $landingData['framework_name'] ?? 'this framework';
        $headline      = $landingData['hero_headline'] ?? '';
        $concepts      = collect($landingData['concepts'] ?? [])->map(fn($c) => "- {$c['name']}: {$c['principle']}")->implode("\n");

        $personas = self::personaDefinitions();
        $persona  = $personas[$personaKey] ?? $personas['enterprise_automation'];

        $prompt = <<<PROMPT
You are a developer marketing strategist at Workato. Generate 6 campaign distribution packages for a specific developer persona.

PERSONA: {$persona['label']} ({$persona['group']})
AUDIENCE: {$persona['audience']}
EMPHASIS: {$persona['emphasis']}
TONE: {$persona['tone']}

Anchor content:
Title: {$frameworkName}
Headline: {$headline}
Key concepts:
{$concepts}

Full source:
{$content}

ALL 6 packages must be written specifically for the persona above. Angle the copy toward what THEY care about. Same underlying content — different emphasis, proof points, and framing.

Return ONLY valid JSON (no markdown, no explanation):
{
  "packages": [
    {
      "channel": "blog",
      "title": "Blog post title",
      "copy": "250-300 word blog intro angled for this persona. First paragraph hooks with their specific problem. Second explains the framework through their lens. Third is a CTA."
    },
    {
      "channel": "linkedin",
      "title": "LinkedIn post title",
      "copy": "150-200 words. Opens with a hook relevant to this persona. Numbered list of 3-5 insights that resonate with their role. Closes with a question or CTA."
    },
    {
      "channel": "twitter",
      "title": "Twitter / X thread title",
      "copy": "A 5-tweet thread. Each tweet on a new line, prefixed with the tweet number (1/, 2/, etc). Max 280 chars per tweet. First tweet is the hook for this persona."
    },
    {
      "channel": "newsletter",
      "title": "Newsletter blurb title",
      "copy": "80-120 words. Conversational. Relevant to this persona's day-to-day. Clear value prop. Link CTA at the end."
    },
    {
      "channel": "video",
      "title": "Short video script title",
      "copy": "150-200 word script for a 60-90 second video. Opens with the specific problem this persona faces. Explains the solution in their terms. Ends with a CTA. Include [PAUSE] markers."
    },
    {
      "channel": "tutorial",
      "title": "Developer tutorial title",
      "copy": "200 word outline for a hands-on tutorial designed for this persona. Includes: what you'll learn, prerequisites appropriate to their role, 4-5 step outline, what you'll have at the end."
    }
  ]
}
PROMPT;

        $raw  = $this->callClaude($prompt);
        $data = json_decode($raw, true);

        if (!$data) {
            preg_match('/\{.*\}/s', $raw, $m);
            $data = json_decode($m[0] ?? '{}', true) ?? [];
        }

        return $data['packages'] ?? [];
    }

    private function callClaude(string $prompt): string
    {
        $response = Http::withHeaders([
            'x-api-key'         => $this->apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->timeout(60)->post('https://api.anthropic.com/v1/messages', [
            'model'      => $this->model,
            'max_tokens' => 4096,
            'messages'   => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response->json('content.0.text', '{}');
    }
}
