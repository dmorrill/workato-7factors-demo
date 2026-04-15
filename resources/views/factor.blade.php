@extends('layouts.app')

@section('title', 'Factor ' . $factor['number'] . ': ' . $factor['name'] . ' — Seven Factors · Workato')

@section('content')

{{-- Header --}}
<section class="bg-hero-gradient text-white py-20 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ url('/') }}#factors" class="inline-flex items-center gap-2 text-gray-400 hover:text-white text-sm mb-10 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            All seven factors
        </a>
        <div class="flex items-start gap-6">
            <span class="text-6xl font-bold text-gray-700 leading-none shrink-0">{{ $factor['number'] }}</span>
            <div>
                <p class="text-[#67EADD] text-sm font-semibold uppercase tracking-wider mb-2">Factor {{ $number }} of 7</p>
                <h1 class="text-4xl md:text-5xl font-bold font-display mb-4 leading-tight">{{ $factor['name'] }}</h1>
                <p class="text-xl text-gray-300 italic leading-relaxed">{{ $factor['principle'] }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Main content --}}
<section class="bg-[#F4F2E3] py-20 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="grid md:grid-cols-3 gap-12">
            {{-- Main text --}}
            <div class="md:col-span-2 space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">The principle</h2>
                    <p class="text-gray-600 leading-relaxed text-lg">{{ $factor['description'] }}</p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">In practice</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $factor['detail'] }}</p>
                </div>

                <div class="bg-[#E1FFEC] border border-[#B3FEF7] rounded-2xl p-7">
                    <p class="text-xs font-semibold text-[#67EADD] uppercase tracking-wider mb-3">Example</p>
                    <p class="text-gray-700 leading-relaxed">{{ $factor['example'] }}</p>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-7">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Design rule</p>
                    <p class="text-gray-800 font-medium leading-relaxed">{{ $factor['rule'] }}</p>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Navigation --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">All factors</p>
                    <nav class="space-y-1">
                        @foreach($allFactors as $n => $f)
                        <a href="{{ url('/factor/' . $n) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ $n === $number ? 'bg-[#67EADD] text-[#083763] font-semibold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                            <span class="font-mono text-xs {{ $n === $number ? 'text-[#B3FEF7]' : 'text-gray-400' }}">{{ $f['number'] }}</span>
                            {{ $f['name'] }}
                        </a>
                        @endforeach
                    </nav>
                </div>

                {{-- Related factors --}}
                @if(!empty($factor['related']))
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Related factors</p>
                    <div class="space-y-2">
                        @foreach($factor['related'] as $rel)
                        <a href="{{ url('/factor/' . $rel) }}"
                           class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#67EADD] hover:bg-[#E1FFEC] transition-colors group">
                            <span class="text-lg font-bold text-gray-300 group-hover:text-[#67EADD] transition-colors">{{ $allFactors[$rel]['number'] }}</span>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $allFactors[$rel]['name'] }}</p>
                                <p class="text-gray-400 text-xs mt-0.5">{{ $allFactors[$rel]['principle'] }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Prev / Next navigation --}}
<section class="bg-gray-50 border-t border-gray-200 py-10 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
        @if($number > 1)
        <a href="{{ url('/factor/' . ($number - 1)) }}"
           class="flex items-center gap-3 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <div>
                <p class="text-xs text-gray-400">Previous</p>
                <p>{{ $allFactors[$number - 1]['name'] }}</p>
            </div>
        </a>
        @else
        <div></div>
        @endif

        <a href="{{ url('/') }}#factors" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">All factors</a>

        @if($number < 7)
        <a href="{{ url('/factor/' . ($number + 1)) }}"
           class="flex items-center gap-3 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors group text-right">
            <div>
                <p class="text-xs text-gray-400">Next</p>
                <p>{{ $allFactors[$number + 1]['name'] }}</p>
            </div>
            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        @else
        <div></div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="bg-[#083763] py-16 px-6 lg:px-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-2xl font-bold text-white mb-3">This is a living framework.</h2>
        <p class="text-gray-400 leading-relaxed mb-8">We want contributors. If your team has learned something building agentic systems in production that belongs here, we want to hear it.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button @click="openModal('Contribute on GitHub', 'This would link to the CONTRIBUTING.md on the Seven Factors GitHub repository. If your team has learned something in production that belongs here — a new pattern, a correction, a real-world example — the process for submitting it lives there. The framework is explicitly designed to evolve with community input.')"
                    class="bg-[#67EADD] hover:bg-[#21DBC8] text-[#083763] font-semibold px-7 py-3 rounded-lg transition-colors cursor-pointer">
                Contribute on GitHub
            </button>
            <button @click="openModal('Download white papers', 'This would trigger a download of the full Seven Factors white paper series — one deep-dive document per factor. Each covers architectural patterns, real-world implementation examples, and concrete design rules. In production, gated behind a simple email capture form.')"
                    class="border border-gray-600 hover:border-gray-400 text-white font-semibold px-7 py-3 rounded-lg transition-colors cursor-pointer">
                Download white papers
            </button>
        </div>
    </div>
</section>

@endsection
