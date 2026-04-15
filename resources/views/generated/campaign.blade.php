@extends('layouts.app')

@section('title', 'Campaign Brief — {{ $campaign->title }} · Workato')

@section('content')

{{-- Header --}}
<section class="bg-hero-dark text-white py-20 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 bg-[#0C3A70] border border-gray-700 rounded-full px-4 py-2 text-sm text-gray-300 mb-8">
            <span class="w-2 h-2 bg-[#67EADD] rounded-full"></span>
            Campaign brief · {{ $campaign->framework_name }}
        </div>
        <h1 class="text-4xl md:text-5xl font-bold font-display mb-5 leading-tight">
            One anchor piece.<br class="hidden md:block"> Six distribution packages.
        </h1>
        <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
            Generated from <a href="{{ $campaign->source_url }}" target="_blank" class="text-[#67EADD] hover:underline">{{ $campaign->source_url }}</a>.
            Review each package below, approve what's ready, and skip what isn't.
        </p>
    </div>
</section>

{{-- How it works bar --}}
<section class="bg-white py-8 px-6 lg:px-8 border-b border-gray-200">
    <div class="max-w-4xl mx-auto">
        <div class="hidden md:flex items-center justify-between gap-4 text-sm">
            @foreach([
                ['01', 'Anchor content extracted', 'Source URL scraped or transcript pulled'],
                ['02', 'Landing page generated', 'Headline, concepts, and framing'],
                ['03', 'Six packages ready', 'Blog, social, newsletter, video, tutorial'],
                ['04', 'Review and approve', 'Approve what\'s ready, skip what isn\'t'],
            ] as $step)
            <div class="flex items-start gap-3 flex-1">
                <span class="w-7 h-7 rounded-full bg-[#67EADD] text-[#083763] text-xs font-bold flex items-center justify-center shrink-0">{{ $step[0] }}</span>
                <div>
                    <p class="font-semibold text-gray-900 text-xs">{{ $step[1] }}</p>
                    <p class="text-gray-400 text-xs">{{ $step[2] }}</p>
                </div>
            </div>
            @if(!$loop->last)
            <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            @endif
            @endforeach
        </div>
    </div>
</section>

{{-- Packages --}}
<section class="bg-[#F4F2E3] py-16 px-6 lg:px-8">
    @php
        $packagesByPersona = $campaign->packages->groupBy('persona');
        $activePersonaKeys = $packagesByPersona->keys()->toArray();
        $firstPersona      = $activePersonaKeys[0] ?? null;
        $hasMultiplePersonas = count($activePersonaKeys) > 1;
    @endphp

    <div x-data="{ persona: '{{ $firstPersona }}' }" class="max-w-4xl mx-auto space-y-5">

        {{-- Persona toggle (only shown when multiple personas) --}}
        @if($hasMultiplePersonas)
        <div class="bg-white rounded-2xl border border-[#E6E2D9] px-6 py-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Viewing copy for</p>
            <div class="flex flex-wrap gap-2">
                @foreach($activePersonaKeys as $pKey)
                    @php $pDef = $personaDefs[$pKey] ?? null; @endphp
                    @if($pDef)
                    <button @click="persona = '{{ $pKey }}'"
                            :class="persona === '{{ $pKey }}' ? 'bg-[#083763] text-white border-[#083763]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#083763] hover:text-[#083763]'"
                            class="text-xs font-semibold px-4 py-2 rounded-lg border transition-all">
                        {{ $pDef['label'] }}
                    </button>
                    @endif
                @endforeach
            </div>
        </div>
        @elseif($firstPersona && isset($personaDefs[$firstPersona]))
        <div class="inline-flex items-center gap-2 bg-[#E1FFEC] border border-[#B3FEF7] text-[#083763] text-xs font-semibold px-3 py-1.5 rounded-full">
            <span class="w-1.5 h-1.5 bg-[#21DBC8] rounded-full"></span>
            {{ $personaDefs[$firstPersona]['label'] }}
        </div>
        @endif

        @foreach($activePersonaKeys as $pKey)
        @php $personaPackages = $packagesByPersona[$pKey] ?? collect(); @endphp
        <div x-show="persona === '{{ $pKey }}'" class="space-y-5">
        @foreach($personaPackages as $package)
        <div x-data="{ tab: 'copy' }" class="bg-white rounded-2xl border border-[#E6E2D9] overflow-hidden">
            {{-- Card header --}}
            <div class="flex items-center justify-between px-7 py-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-8 rounded-full {{ $package->status === 'approved' ? 'bg-[#67EADD]' : ($package->status === 'skipped' ? 'bg-gray-200' : 'bg-[#1D60CA]') }}"></div>
                    <div>
                        <p class="text-xs font-semibold text-[#1D60CA] uppercase tracking-wider">{{ $package->channelLabel() }}</p>
                        <p class="font-bold text-gray-900 text-sm">{{ $package->title }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($package->status === 'approved')
                        <span class="text-xs bg-[#E1FFEC] text-[#083763] px-3 py-1 rounded-full font-semibold border border-[#B3FEF7]">✓ Approved</span>
                    @elseif($package->status === 'skipped')
                        <span class="text-xs bg-gray-100 text-gray-400 px-3 py-1 rounded-full font-medium">Skipped</span>
                    @else
                        <form method="POST" action="{{ route('make.package', [$campaign->id, $package->id]) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button class="text-xs font-semibold text-[#083763] bg-[#E1FFEC] hover:bg-[#B3FEF7] border border-[#67EADD] px-3 py-1.5 rounded-lg transition-colors cursor-pointer">
                                ✓ Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('make.package', [$campaign->id, $package->id]) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="skipped">
                            <button class="text-xs font-semibold text-gray-500 bg-white hover:bg-gray-50 border border-gray-200 px-4 py-1.5 rounded-lg transition-colors cursor-pointer">
                                Skip
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Tabs --}}
            <div class="px-7 pt-4">
                <div class="flex gap-1 bg-gray-100 rounded-lg p-1 w-fit">
                    <button @click="tab = 'copy'"
                            :class="tab === 'copy' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'"
                            class="text-xs font-medium px-3 py-1.5 rounded-md transition-all">
                        Draft copy
                    </button>
                    <button @click="tab = 'image'"
                            :class="tab === 'image' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'"
                            class="text-xs font-medium px-3 py-1.5 rounded-md transition-all">
                        Social image
                    </button>
                </div>
            </div>

            {{-- Copy tab --}}
            <div x-show="tab === 'copy'" class="p-7">
                <div class="font-mono-code text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 rounded-xl p-5 border border-gray-100">{{ $package->copy }}</div>
            </div>

            {{-- Social image tab --}}
            <div x-show="tab === 'image'" class="p-7">
                <div class="bg-[#083763] rounded-xl overflow-hidden aspect-video max-w-sm flex flex-col items-center justify-center gap-4 p-8 text-center relative mx-auto">
                    <svg width="40" height="40" viewBox="0 0 32 32" fill="none">
                        <rect width="32" height="32" rx="8" fill="#67EADD"/>
                        <path d="M8 10h3.5l2.5 8 2.5-8h3l2.5 8 2.5-8H28l-4.5 12h-3l-2.5-7.5L15.5 22h-3L8 10z" fill="#083763"/>
                    </svg>
                    <p class="text-white font-bold font-display text-sm leading-snug">{{ $package->title }}</p>
                    <p class="text-[#67EADD] text-xs font-semibold uppercase tracking-wider">{{ $campaign->framework_name }}</p>
                    <button @click="openModal('Generate social image', 'In production this would call the Wolf2 brand kit to generate a social image using the approved color palette, Besley + Nunito Sans typography, and official Dewy poses. All generated assets go through Team Dewy approval before use.')"
                            class="mt-2 text-xs font-semibold text-[#083763] bg-[#67EADD] hover:bg-[#21DBC8] px-4 py-2 rounded-lg transition-colors cursor-pointer">
                        Generate with brand kit
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        </div>
        @endforeach

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('generated.landing', $campaign->slug) }}"
               class="text-sm text-gray-500 hover:text-[#083763] transition-colors">
                ← View landing page
            </a>
            <a href="{{ route('make.show', $campaign->id) }}"
               class="text-sm text-gray-500 hover:text-[#083763] transition-colors">
                Edit in Campaign Maker →
            </a>
        </div>

    </div>
</section>

@endsection
