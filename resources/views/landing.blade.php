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
            [1, '01', 'Governed Operations', 'No enterprise concern delegates to an agentic protocol.'],
            [2, '02', 'Deterministic Mutations', 'All state mutations belong to the control plane.'],
            [3, '03', 'Intent-Based Communication', 'Tool boundaries follow intent, not implementation.'],
            [4, '04', 'Bounded Access', 'Each caller sees only the capabilities its role requires.'],
            [5, '05', 'Safe Retries', 'Every mutation is safely retried by a probabilistic caller.'],
            [6, '06', 'Recovery Contracts', 'The reasoning layer never guesses at state.'],
            [7, '07', 'Structural Observability', 'Every agent action is reconstructable by architecture.'],
        ];
        @endphp

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($factors as [$num, $display, $name, $principle])
            <a href="{{ url('/factor/' . $num) }}"
               class="group bg-[#1A1D3E] hover:bg-[#1F2347] rounded-2xl p-7 border border-gray-700 hover:border-[#FF5F36] transition-all flex flex-col {{ $num === 7 ? 'md:col-span-2 lg:col-span-1' : '' }}">
                <div class="flex items-start justify-between mb-5">
                    <span class="text-3xl font-bold text-gray-700 leading-none">{{ $display }}</span>
                    <svg class="w-4 h-4 text-gray-600 group-hover:text-[#FF5F36] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/>
                    </svg>
                </div>
                <h3 class="text-white font-bold text-lg mb-3 leading-snug">{{ $name }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed flex-1">{{ $principle }}</p>
                <p class="text-[#FF5F36] text-xs font-semibold mt-5 group-hover:underline">Read more →</p>
            </a>
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
            @foreach(\App\Data\Factors::all() as $n => $factor)
            <a href="{{ url('/factor/' . $n) }}" class="flex items-start gap-4 p-5 rounded-xl border border-gray-200 hover:border-[#FF5F36] hover:bg-[#FFF8F6] transition-colors cursor-pointer group">
                <div class="w-5 h-5 rounded border-2 border-gray-300 group-hover:border-[#FF5F36] shrink-0 mt-0.5 transition-colors"></div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">{{ $factor['name'] }}</p>
                    <p class="text-gray-500 text-sm mt-0.5">{{ $factor['principle'] }}</p>
                </div>
            </a>
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
                @foreach(array_slice(\App\Data\Factors::all(), 0, 4, true) as $n => $factor)
                <a href="{{ url('/factor/' . $n) }}" class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:border-[#FF5F36] transition-colors">
                    <p class="text-xs font-semibold text-[#FF5F36] mb-1">Factor {{ $factor['number'] }}</p>
                    <p class="font-semibold text-gray-900 text-sm leading-snug">{{ $factor['name'] }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Twelve-Factor framing --}}
<section class="bg-white py-20 px-6 lg:px-8 border-t border-gray-200">
    <div class="max-w-4xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-xs font-semibold text-[#FF5F36] uppercase tracking-wider mb-4">The ambition</p>
                <h2 class="text-3xl font-bold text-gray-900 mb-5 leading-tight">The Twelve-Factor App defined how cloud-native apps should be built. We're trying to do the same thing for agents.</h2>
                <p class="text-gray-500 leading-relaxed mb-4">
                    Adam Wiggins published the Twelve-Factor App at Heroku over a decade ago. It wasn't a Heroku product — it was a neutral methodology that gave the whole industry a shared vocabulary. Developers still cite it today. Heroku open-sourced its governance in 2024.
                </p>
                <p class="text-gray-500 leading-relaxed">
                    The Seven Factors is an attempt at the same thing — for the agentic era. A framework the field can build on, cite, debate, and improve. Not a Workato product. Something that raises the reliability bar for everyone building agents.
                </p>
            </div>
            <div class="space-y-4">
                <div class="flex items-start gap-5 p-6 rounded-2xl bg-gray-50 border border-gray-200">
                    <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center shrink-0 text-lg font-bold text-gray-500">12</div>
                    <div>
                        <p class="font-bold text-gray-900 mb-1">Twelve-Factor App <span class="text-gray-400 font-normal text-sm">— 2011</span></p>
                        <p class="text-gray-500 text-sm leading-relaxed">A methodology for building cloud-native SaaS apps. Published at Heroku, adopted by the industry. Still the reference for platform engineers a decade later.</p>
                        <p class="text-gray-400 text-xs mt-2">Scope: How apps should be built for the cloud.</p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-6 rounded-2xl bg-[#FFF8F6] border border-orange-200">
                    <div class="w-12 h-12 rounded-xl bg-[#FF5F36] flex items-center justify-center shrink-0 text-lg font-bold text-white">7</div>
                    <div>
                        <p class="font-bold text-gray-900 mb-1">Seven Factors <span class="text-gray-400 font-normal text-sm">— 2026</span></p>
                        <p class="text-gray-500 text-sm leading-relaxed">A framework for building reliable, secure agentic systems. Published at Workato, intended for the whole industry. Built from production deployments across thousands of enterprises.</p>
                        <p class="text-[#FF5F36] text-xs mt-2 font-medium">Scope: How agents should interact with enterprise systems.</p>
                    </div>
                </div>
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
