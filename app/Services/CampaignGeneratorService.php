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

    public function generate(array $extracted): array
    {
        $landingData = $this->generateLandingPage($extracted['text'], $extracted['title'] ?? '');
        $packages    = $this->generatePackages($extracted['text'], $landingData);

        return [
            'landing'  => $landingData,
            'packages' => $packages,
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

    private function generatePackages(string $content, array $landingData): array
    {
        $frameworkName = $landingData['framework_name'] ?? 'this framework';
        $headline      = $landingData['hero_headline'] ?? '';
        $concepts      = collect($landingData['concepts'] ?? [])->map(fn($c) => "- {$c['name']}: {$c['principle']}")->implode("\n");

        $prompt = <<<PROMPT
You are a developer marketing strategist at Workato. Generate 6 campaign distribution packages based on this anchor content.

Anchor:
Title: {$frameworkName}
Headline: {$headline}
Key concepts:
{$concepts}

Full source:
{$content}

Return ONLY valid JSON (no markdown, no explanation):
{
  "packages": [
    {
      "channel": "blog",
      "title": "Blog post title",
      "copy": "250-300 word blog intro. Developer-friendly but readable by business stakeholders. First paragraph hooks with the problem. Second explains the framework. Third is a CTA to read more."
    },
    {
      "channel": "linkedin",
      "title": "LinkedIn post title",
      "copy": "150-200 words. Opens with a strong first line. Numbered list of 3-5 key insights. Closes with a question or CTA. Professional but not corporate."
    },
    {
      "channel": "twitter",
      "title": "Twitter / X thread title",
      "copy": "A 5-tweet thread. Each tweet on a new line, prefixed with the tweet number (1/, 2/, etc). Max 280 chars per tweet. First tweet is the hook."
    },
    {
      "channel": "newsletter",
      "title": "Newsletter blurb title",
      "copy": "80-120 words. Conversational. Suitable for a developer newsletter. Clear value prop. Link CTA at the end."
    },
    {
      "channel": "video",
      "title": "Short video script title",
      "copy": "150-200 word script for a 60-90 second video. Opens with the problem. Explains the concept. Ends with a CTA. Include [PAUSE] markers."
    },
    {
      "channel": "tutorial",
      "title": "Developer tutorial title",
      "copy": "200 word outline for a hands-on tutorial. Includes: what you'll learn, prerequisites, 4-5 step outline, what you'll have at the end."
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
