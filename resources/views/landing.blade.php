@extends('layouts.app')

@section('title', 'Seven Factors of the Agentic Control Plane — Workato')

@section('content')

{{-- Hero --}}
<section class="bg-[#0D0F2B] text-white py-24 px-6 lg:px-8">
    <div class="max-w-5xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-[#1A1D3E] border border-gray-700 rounded-full px-4 py-2 text-sm text-gray-300 mb-8">
            <span class="w-2 h-2 bg-[#FF5F36] rounded-full"></span>
            Enterprise MCP · Published April 2026
        </div>
        <h1 class="text-4xl md:text-6xl font-bold leading-tight tracking-tight mb-6">
            You're building agents faster<br class="hidden md:block"> than your governance can keep up.
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed mb-10">
            The Seven Factors of the Agentic Control Plane is an open framework for building reliable, secure, enterprise-grade autonomous agent systems — distilled from production deployments across thousands of enterprises.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#factors" class="bg-[#FF5F36] hover:bg-[#E54E27] text-white font-semibold px-8 py-3.5 rounded-lg transition-colors text-base">
                Explore the framework
            </a>
            <a href="#whitepaper" class="border border-gray-600 hover:border-gray-400 text-white font-semibold px-8 py-3.5 rounded-lg transition-colors text-base">
                Download white paper
            </a>
        </div>
    </div>
</section>

{{-- Video --}}
<section class="bg-[#0D0F2B] pb-20 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-700" style="padding-bottom: 56.25%; height: 0;">
            <iframe
                class="absolute top-0 left-0 w-full h-full"
                src="https://www.youtube.com/embed/zsQjoUECVRc"
                title="Enterprise MCP: The Data Plane for Autonomous Agents — Adam Seligman & Zayne Turner"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
        <p class="text-center text-gray-400 text-sm mt-4">
            MCP Dev Summit, New York · Adam Seligman &amp; Zayne Turner, Workato
        </p>
    </div>
</section>

{{-- Two-layer architecture --}}
<section class="bg-white py-24 px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Every agentic system has two layers.</h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">Whether you've designed for it or not. The question is whether they're working together correctly.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-12">
            {{-- Probabilistic layer --}}
            <div class="rounded-2xl border-2 border-gray-200 p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Layer 1</p>
                        <h3 class="font-bold text-gray-900 text-lg">Reasoning Layer</h3>
                    </div>
                </div>
                <p class="text-gray-500 text-sm mb-4 leading-relaxed">The LLM and agent logic. Handles intent, planning, and deciding what should happen next. This is a <strong class="text-gray-700">probabilistic layer</strong> — it may or may not do things correctly.</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(['LLM', 'Agent logic', 'Intent', 'Planning', 'Orchestration'] as $tag)
                    <span class="bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1 rounded-full">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Deterministic layer --}}
            <div class="rounded-2xl border-2 border-[#FF5F36] bg-[#FFF8F6] p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#FF5F36] flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-[#FF5F36] uppercase tracking-wider">Layer 2</p>
                        <h3 class="font-bold text-gray-900 text-lg">Control Plane</h3>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4 leading-relaxed">Where governance, authentication, authorization, and business logic live. This layer <strong class="text-gray-800">must be correct every single time</strong> — because in business, there are consequences.</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Governance', 'Auth', 'Business logic', 'Mutations', 'Observability'] as $tag)
                    <span class="bg-orange-50 text-[#FF5F36] text-xs font-medium px-3 py-1 rounded-full border border-orange-200">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-2xl p-8 text-center border border-gray-200">
            <p class="text-gray-700 text-lg font-medium italic max-w-2xl mx-auto">
                "These are not equal partners. The probabilistic layer may or may not do things correctly — but the control plane needs to be correct every single time."
            </p>
            <p class="text-gray-400 text-sm mt-3">Adam Seligman, CTO &amp; GM Developer Business, Workato</p>
        </div>
    </div>
</section>

{{-- Seven Factors --}}
<section id="factors" class="bg-[#0D0F2B] py-24 px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">The Seven Factors</h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">Does your agent have a control plane? These seven factors tell you whether your agentic system is built for enterprise reliability.</p>
        </div>

        @php
        $factors = [
            [
                'number' => '01',
                'name' => 'Governed Operations',
                'principle' => 'No enterprise concern delegates to an agentic protocol.',
                'description' => 'Protocols like MCP are thin by design — purpose-built for specific things in the reasoning layer. They don\'t take care of enterprise concerns. You have to. Don\'t wait for the standard to adopt what your business needs right now.',
                'example' => 'If you\'re in a regulated industry, the dial goes up further. Authentication, audit trails, compliance controls — none of that belongs inside the protocol layer.',
            ],
            [
                'number' => '02',
                'name' => 'Deterministic Mutations',
                'principle' => 'All state mutations belong to the control plane.',
                'description' => 'The control plane should own all creates, writes, and deletes. Never allow the probabilistic reasoning layer to have direct write access to state it could destroy. The deterministic layer controls mutations to data your business cares about.',
                'example' => 'A clinician needs the right prescription. A customer needs exactly one charge. These guarantees belong in the control plane — not in the LLM.',
            ],
            [
                'number' => '03',
                'name' => 'Intent-Based Communication',
                'principle' => 'Tool boundaries follow intent, not implementation.',
                'description' => 'How probabilistic callers communicate with the control plane should be about the tool\'s intent — not leaking details about the underlying implementation. Don\'t flood the LLM context with a sequence of raw API calls. Start with the intent, work backwards.',
                'example' => 'Abstracting away the implementation layer frees up context for richer reasoning — and minimizes exfiltration surface area by hiding what system is being called and how.',
            ],
            [
                'number' => '04',
                'name' => 'Bounded Access',
                'principle' => 'Each caller sees only the capabilities its role requires.',
                'description' => 'Least privilege isn\'t new — but the patterns look different in the agentic era. When callers are probabilistic and behaviors are non-deterministic, gateway-level filtering and per-role tool restrictions become critical for minimizing blast radius.',
                'example' => 'If a prompt-injected agent encounters the lethal trifecta, bounded access is what limits the damage. The blast radius should be minimized by design, not by hope.',
            ],
            [
                'number' => '05',
                'name' => 'Safe Retries',
                'principle' => 'Every mutation is safely retried by a probabilistic caller.',
                'description' => 'When your caller is probabilistic, it doesn\'t know whether it\'s calling for the first time or the second. Your idempotency keys break. Your deduplication layers stop working correctly. You have to build for different retry patterns than you\'re used to.',
                'example' => 'Backend systems that assume external callers send genuinely identical keys are wrong now. The same request from a probabilistic caller may arrive in subtly different forms each time.',
            ],
            [
                'number' => '06',
                'name' => 'Recovery Contracts',
                'principle' => 'The reasoning layer never guesses at state.',
                'description' => 'If retries are different, errors are different too. Logic can\'t always branch deterministically on a 400 vs. a 500. The control plane needs to give the reasoning layer a message about whether it\'s safe to retry — not just a static error code to be interpreted.',
                'example' => 'A reasoning caller receiving a raw 500 doesn\'t know what happened or what to do next. A recovery contract tells it: here\'s what occurred, here\'s whether it\'s safe to try again.',
            ],
            [
                'number' => '07',
                'name' => 'Structural Observability',
                'principle' => 'Every agent action is reconstructable by architecture.',
                'description' => 'LLMs are black boxes. Even if you ask one what it did, you\'re not guaranteed to get a truthful answer. Observability has to be enforced outside the LLM — in the deterministic control layer, by design, not because a developer decided to capture a log.',
                'example' => 'What happened? What was the intent? What system called and why? These questions need answers the architecture guarantees — not answers the LLM volunteers.',
            ],
        ];
        @endphp

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($factors as $i => $factor)
            <div class="bg-[#1A1D3E] rounded-2xl p-7 border border-gray-700 hover:border-[#FF5F36] transition-colors group {{ $i === 6 ? 'md:col-span-2 lg:col-span-1' : '' }}">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-4xl font-bold text-gray-700 leading-none">{{ $factor['number'] }}</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#FF5F36] mt-1.5 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                </div>
                <h3 class="text-white font-bold text-lg mb-2">{{ $factor['name'] }}</h3>
                <p class="text-[#FF5F36] text-sm font-medium italic mb-3 leading-snug">{{ $factor['principle'] }}</p>
                <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ $factor['description'] }}</p>
                <div class="bg-[#0D0F2B] rounded-xl p-4 border border-gray-700">
                    <p class="text-gray-500 text-xs leading-relaxed">{{ $factor['example'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Self-assessment checklist --}}
<section class="bg-white py-20 px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Does your agent have a control plane?</h2>
            <p class="text-gray-500">A quick self-assessment for architects and engineering leads evaluating their agentic deployments.</p>
        </div>
        <div class="space-y-3">
            @foreach($factors as $factor)
            <div class="flex items-start gap-4 p-5 rounded-xl border border-gray-200 hover:border-[#FF5F36] hover:bg-[#FFF8F6] transition-colors cursor-pointer group">
                <div class="w-5 h-5 rounded border-2 border-gray-300 group-hover:border-[#FF5F36] shrink-0 mt-0.5 transition-colors"></div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">{{ $factor['name'] }}</p>
                    <p class="text-gray-500 text-sm mt-0.5">{{ $factor['principle'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <p class="text-center text-gray-400 text-sm mt-8">This checklist is part of the open Seven Factors framework. <a href="#whitepaper" class="text-[#FF5F36] hover:underline">Read the full white paper →</a></p>
    </div>
</section>

{{-- White papers --}}
<section id="whitepaper" class="bg-gray-50 py-20 px-6 lg:px-8 border-t border-gray-200">
    <div class="max-w-5xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Go deeper on each factor.</h2>
                <p class="text-gray-500 leading-relaxed mb-6">
                    The Seven Factors white paper series goes live with the framework launch. Each factor gets a dedicated deep-dive — architectural patterns, real-world examples, and implementation guidance for enterprise deployments.
                </p>
                <p class="text-gray-500 leading-relaxed mb-8">
                    This is an open, living framework. We want contributors. If your team has learned something in production that belongs here, we want to hear it.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="#" class="bg-[#FF5F36] hover:bg-[#E54E27] text-white font-semibold px-6 py-3 rounded-lg text-sm transition-colors text-center">
                        Download white papers
                    </a>
                    <a href="#" class="border border-gray-300 hover:border-gray-400 text-gray-700 font-semibold px-6 py-3 rounded-lg text-sm transition-colors text-center">
                        View on GitHub
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach(array_slice($factors, 0, 4) as $factor)
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-xs font-semibold text-[#FF5F36] mb-1">Factor {{ $factor['number'] }}</p>
                    <p class="font-semibold text-gray-900 text-sm leading-snug">{{ $factor['name'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Community CTA --}}
<section class="bg-[#0D0F2B] py-20 px-6 lg:px-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-white mb-4">This is an industry conversation, not a Workato conversation.</h2>
        <p class="text-gray-400 text-lg leading-relaxed mb-10">
            The themes in these seven factors are converging across the field. We built this from production experience across thousands of enterprise deployments — but we don't think we have all the answers. Join us in building the reliability bar for agents everywhere.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#" class="bg-[#FF5F36] hover:bg-[#E54E27] text-white font-semibold px-8 py-3.5 rounded-lg transition-colors">
                Contribute to the framework
            </a>
            <a href="#" class="border border-gray-600 hover:border-gray-400 text-white font-semibold px-8 py-3.5 rounded-lg transition-colors">
                See Dewy Resort (open source)
            </a>
        </div>
        <p class="text-gray-600 text-sm mt-8">Built by <a href="#" class="text-gray-400 hover:text-white transition-colors">Zayne Turner</a> and the Workato developer platform team · <a href="#" class="text-gray-400 hover:text-white transition-colors">workato.com/7factors</a></p>
    </div>
</section>

@endsection
