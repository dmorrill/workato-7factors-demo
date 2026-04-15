@extends('layouts.app')

@section('title', 'Campaign Brief — Seven Factors · Workato')

@section('content')

{{-- Header --}}
<section class="bg-[#0D0F2B] text-white py-20 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 bg-[#1A1D3E] border border-gray-700 rounded-full px-4 py-2 text-sm text-gray-300 mb-8">
            <span class="w-2 h-2 bg-[#FF5F36] rounded-full"></span>
            WS1 · Content Amplification · Campaign Template
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-5 leading-tight">What a content campaign looks like<br class="hidden md:block"> when the system works.</h1>
        <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
            One anchor piece. Six distribution-ready content packages. A 15-minute review process. This is the template — for this keynote and every piece of anchor content that follows.
        </p>
    </div>
</section>

{{-- Anchor content --}}
<section class="bg-white py-16 px-6 lg:px-8 border-b border-gray-200">
    <div class="max-w-4xl mx-auto">
        <p class="text-xs font-semibold text-[#FF5F36] uppercase tracking-wider mb-3">Anchor Content</p>
        <div class="flex flex-col md:flex-row gap-8 items-start">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Enterprise MCP: The Data Plane for Autonomous Agents</h2>
                <p class="text-gray-500 mb-4">Adam Seligman &amp; Zayne Turner · MCP Dev Summit, New York · April 2026</p>
                <div class="flex flex-wrap gap-3 text-sm">
                    <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg font-medium">~8 minutes</span>
                    <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg font-medium">YouTube · Public</span>
                    <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg font-medium">Full transcript available</span>
                    <span class="bg-orange-50 text-[#FF5F36] px-3 py-1.5 rounded-lg font-medium border border-orange-200">0 distribution actions taken</span>
                </div>
            </div>
            <a href="https://www.youtube.com/watch?v=zsQjoUECVRc" target="_blank" class="shrink-0 block w-full md:w-64 rounded-xl overflow-hidden border border-gray-200 hover:border-[#FF5F36] transition-colors group">
                <div class="bg-gray-900 aspect-video flex items-center justify-center relative">
                    <img src="https://img.youtube.com/vi/zsQjoUECVRc/mqdefault.jpg" alt="Keynote thumbnail" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/20 transition-colors">
                        <div class="w-12 h-12 bg-[#FF5F36] rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-gray-50">
                    <p class="text-xs font-medium text-gray-700">Watch on YouTube →</p>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- Campaign pieces --}}
<section class="bg-gray-50 py-20 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-xs font-semibold text-[#FF5F36] uppercase tracking-wider mb-2">Campaign Package</p>
                <h2 class="text-2xl font-bold text-gray-900">6 content pieces, ready for review.</h2>
            </div>
            <div class="hidden md:flex items-center gap-3 bg-white border border-gray-200 rounded-xl px-5 py-3 text-sm">
                <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                <span class="text-gray-600 font-medium">Awaiting Natala's review</span>
            </div>
        </div>

        @php
        $pieces = [
            [
                'number' => '01',
                'type' => 'LinkedIn Post',
                'audience' => 'Technical leaders & architects',
                'angle' => 'The two-layer framing',
                'platform_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                'why' => 'The core insight from the keynote — distilled into a shareable frame. This is the "stop and think" post for anyone building agentic systems.',
                'copy' => "Every agentic system has two layers, whether you've designed for it or not.\n\nLayer 1: The reasoning layer — your LLM, your agent logic, the thing that figures out what should happen. This is probabilistic. It may or may not do things correctly.\n\nLayer 2: The control plane — where governance, authentication, and business logic live. This must be correct every single time.\n\nThese are not equal partners.\n\nWe've been thinking a lot about this at Workato — distilled into the Seven Factors of the Agentic Control Plane. Worth 8 minutes: workato.com/7factors\n\n#MCP #AgenticAI #EnterpriseAI",
            ],
            [
                'number' => '02',
                'type' => 'Developer Thread',
                'audience' => 'Developers building agentic systems',
                'angle' => 'The idempotency insight',
                'platform_color' => 'bg-gray-100 text-gray-700 border-gray-300',
                'why' => 'The most technically sharp moment in the keynote. Developers building agents right now will stop scrolling for this — it\'s a real gotcha they\'re hitting.',
                'copy' => "Your idempotency keys are broken.\n\nNot a bug. A fundamental shift in how probabilistic callers work.\n\nHere's what changed:\n\n→ Your backend was designed for callers that know whether they're calling for the first time or second time\n→ A probabilistic LLM caller doesn't know this\n→ So it may send the \"same\" request in subtly different forms each time\n→ Your deduplication layer can't dedup something that looks slightly different\n\nThis is Factor 5 of the Agentic Control Plane: Safe Retries.\n\nYou have to build for different retry patterns than you're used to. Your control plane needs to be the one handling this — not the reasoning layer.\n\nFull breakdown: workato.com/7factors",
            ],
            [
                'number' => '03',
                'type' => 'Short-Form Post',
                'audience' => 'Broad — developers, technical leaders, AI practitioners',
                'angle' => 'The HTTPS badge analogy',
                'platform_color' => 'bg-gray-100 text-gray-700 border-gray-300',
                'why' => 'Memorable, historically grounded, instantly relatable. Works on LinkedIn and X. Doesn\'t require technical depth to land.',
                'copy' => "Remember when early banking and ecommerce sites put up little badges that said \"Don't worry, we use HTTPS. Shopping with us is totally secure.\"\n\nAnd then we all learned there's a lot more to security than that.\n\nWe're doing the same thing with MCP right now.\n\n\"Don't worry, we use MCP\" is not a governance strategy.\n\nworkato.com/7factors",
            ],
            [
                'number' => '04',
                'type' => 'CTA Post',
                'audience' => 'Anyone who engaged with pieces 01–03',
                'angle' => 'Drive to /7factors and white papers',
                'platform_color' => 'bg-orange-50 text-[#FF5F36] border-orange-200',
                'why' => 'Closes the loop. Converts engagement on the individual angles into traffic to the anchor. Times well 2–3 days after the primary posts go out.',
                'copy' => "We published the Seven Factors of the Agentic Control Plane at this week's MCP Dev Summit in New York.\n\nIt's an open framework — built from production experience across thousands of enterprise deployments, and we want contributors.\n\nIf your team has learned something building agentic systems that belongs here, we want to hear it.\n\nWhite papers are live. Framework is open.\n\nworkato.com/7factors",
            ],
            [
                'number' => '05',
                'type' => 'Video Clip',
                'audience' => 'LinkedIn / Twitter — broad',
                'angle' => 'The HTTPS badge moment (clip)',
                'platform_color' => 'bg-red-50 text-red-600 border-red-200',
                'why' => 'The most shareable 30-second moment in the keynote. Adam tells the HTTPS banking story naturally and with the right energy. Clip from ~10:01 in the video.',
                'copy' => "Source: youtube.com/watch?v=zsQjoUECVRc\nTimestamp: ~4:04 into the video\nDuration: ~30 seconds\n\nTranscript of clip:\n\"I'm old enough — I remember in the early days of banking and ecommerce, the segment of little badges: 'Don't worry, we use HTTPS, you shopping or banking with us is totally secure.' And then — well, there's a lot more than that.\"\n\nCaption: Governance theater vs. real governance. The same pattern is showing up in MCP. workato.com/7factors\n\n[Request clip edit from Annie / social team]",
            ],
            [
                'number' => '06',
                'type' => 'LinkedIn Post',
                'audience' => 'Developers, platform engineers, technical leaders',
                'angle' => 'The Twelve-Factor parallel',
                'platform_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                'why' => 'The strongest credibility frame for this work — and the one that signals Adam\'s actual ambition. Anyone who knows what the Twelve-Factor App is will immediately understand what the Seven Factors is trying to become. That\'s exactly the developer audience Workato needs to reach.',
                'copy' => "In 2011, Adam Wiggins published the Twelve-Factor App at Heroku.\n\nIt wasn't a Heroku product. It was a neutral methodology — a shared vocabulary for how SaaS apps should be built for the cloud. Developers still cite it today. Platforms still build for it. Heroku open-sourced its governance last year.\n\nWe're trying to do the same thing for agents.\n\nThe Seven Factors of the Agentic Control Plane isn't a Workato product either. It's a framework for how agents should interact with enterprise systems — built from production experience, open to contribution, intended for the whole industry.\n\nThe field is converging on these patterns whether or not we name them. We'd rather name them together.\n\nworkato.com/7factors",
            ],
        ];
        @endphp

        <div class="space-y-5">
            @foreach($pieces as $piece)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    {{-- Left: metadata --}}
                    <div class="md:w-72 shrink-0 p-7 border-b md:border-b-0 md:border-r border-gray-100 bg-gray-50">
                        <div class="flex items-center gap-3 mb-5">
                            <span class="text-3xl font-bold text-gray-200 leading-none">{{ $piece['number'] }}</span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg border {{ $piece['platform_color'] }}">
                                {{ $piece['type'] }}
                            </span>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Angle</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $piece['angle'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Audience</p>
                                <p class="text-sm text-gray-600">{{ $piece['audience'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Why this angle</p>
                                <p class="text-xs text-gray-500 leading-relaxed">{{ $piece['why'] }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Right: copy --}}
                    <div class="flex-1 p-7">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Draft copy</p>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line font-mono">{{ $piece['copy'] }}</p>
                        </div>
                        <div class="flex items-center gap-3 mt-4">
                            <button @click="openModal('✓ Approve', 'In the live system, this marks the piece as approved and queues it for distribution. It goes into a shared Notion (or Airtable) board visible to Allie and Kayla, tagged with target channel and publish window. Natala\'s approval is the only gate — no further sign-off needed.')"
                                    class="text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 border border-green-200 px-4 py-2 rounded-lg transition-colors cursor-pointer">✓ Approve</button>
                            <button @click="openModal('Edit', 'In the live system, this opens an inline editor (or links to the Notion doc) where Natala can rewrite or annotate the draft. Her edits are saved, the piece is re-queued for a quick re-review before distribution. Over time, edits train the next generation of AI drafts.')"
                                    class="text-xs font-semibold text-gray-500 bg-white hover:bg-gray-50 border border-gray-200 px-4 py-2 rounded-lg transition-colors cursor-pointer">Edit</button>
                            <button @click="openModal('Skip', 'In the live system, this removes the piece from the current cycle without deleting it. Skipped pieces are logged with a reason (optional) so the system learns what doesn\'t resonate. The piece can be surfaced again in a future cycle if the timing changes.')"
                                    class="text-xs font-semibold text-red-500 bg-white hover:bg-red-50 border border-gray-200 px-4 py-2 rounded-lg transition-colors cursor-pointer">Skip</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- The process --}}
<section class="bg-white py-20 px-6 lg:px-8 border-t border-gray-200">
    <div class="max-w-4xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div>
                <p class="text-xs font-semibold text-[#FF5F36] uppercase tracking-wider mb-3">The Process</p>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How this runs — every time.</h2>
                <p class="text-gray-500 leading-relaxed mb-8">
                    The system is designed so Natala's time is a 15-minute review, not a production task. AI handles the derivation. The team handles the distribution. The review is the judgment gate.
                </p>
                <div class="space-y-4">
                    @php
                    $steps = [
                        ['step' => '1', 'title' => 'Anchor content produced', 'desc' => 'Keynote, demo video, blog post, white paper. Any substantial piece from Zayne, Chloe, or the team.'],
                        ['step' => '2', 'title' => 'AI generates derivative package', 'desc' => 'Transcript → 5 content pieces across channels, with angles, audiences, and draft copy.'],
                        ['step' => '3', 'title' => '15-minute review by Natala', 'desc' => 'Approve, edit, or skip each piece. Feedback shapes the next cycle.'],
                        ['step' => '4', 'title' => 'Distribution via Allie + Kayla', 'desc' => 'Corporate social channels publish approved pieces. Personal channels (Zayne, Chloe) publish their own.'],
                        ['step' => '5', 'title' => 'Engagement feeds next cycle', 'desc' => 'What resonated becomes the brief for the next anchor content.'],
                    ];
                    @endphp
                    @foreach($steps as $s)
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-[#FF5F36] text-white flex items-center justify-center text-sm font-bold shrink-0">{{ $s['step'] }}</div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $s['title'] }}</p>
                            <p class="text-gray-500 text-sm mt-0.5">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold text-[#FF5F36] uppercase tracking-wider mb-3">The Template</p>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">This works for any anchor piece.</h2>
                <p class="text-gray-500 leading-relaxed mb-6">
                    The Seven Factors keynote is the first run. The pattern applies to everything that follows.
                </p>
                <div class="space-y-3">
                    @php
                    $examples = [
                        'A new Workato Labs release',
                        'A CLI tutorial from Zayne',
                        'A conference talk or panel',
                        'A Seven Factors white paper drop',
                        'An Otto demo or case study',
                        'A community-built recipe or integration',
                    ];
                    @endphp
                    @foreach($examples as $ex)
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#FF5F36] shrink-0"></div>
                        <p class="text-sm text-gray-700">{{ $ex }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 p-6 bg-[#0D0F2B] rounded-2xl text-white">
                    <p class="text-sm font-semibold mb-2">The goal</p>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        When the Developer Advocate hire is made, they inherit a system that already works — not a blank slate. The process, the templates, and the distribution relationships are already in place.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Bottom CTA --}}
<section class="bg-[#FF5F36] py-16 px-6 lg:px-8">
    <div class="max-w-3xl mx-auto text-center text-white">
        <h2 class="text-2xl font-bold mb-3">Ready to run it.</h2>
        <p class="text-orange-100 leading-relaxed mb-8">
            Five pieces, one anchor, 15-minute review. The Seven Factors keynote is ready to go. This brief is the Natala review package for the first run.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="bg-white text-[#FF5F36] font-semibold px-7 py-3 rounded-lg hover:bg-orange-50 transition-colors">
                View the landing page →
            </a>
            <a href="https://www.youtube.com/watch?v=zsQjoUECVRc" target="_blank" class="border border-white/50 text-white font-semibold px-7 py-3 rounded-lg hover:bg-white/10 transition-colors">
                Watch the keynote
            </a>
        </div>
    </div>
</section>

@endsection
