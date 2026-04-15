@extends('layouts.app')

@section('title', '{{ $campaign->displayName() }} — Campaign Maker · Workato')

@section('content')

<section class="bg-hero-dark text-white py-14 px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <a href="{{ route('make.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white text-sm mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            All campaigns
        </a>
        <div class="flex items-start justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $campaign->status === 'published' ? 'bg-[#E1FFEC] text-[#083763]' : 'bg-[#0C3A70] text-gray-300 border border-gray-600' }}">
                        {{ ucfirst($campaign->status) }}
                    </span>
                    <span class="text-gray-500 text-xs">{{ $campaign->source_type === 'youtube' ? 'YouTube' : 'Web page' }}</span>
                </div>
                <h1 class="text-3xl font-bold font-display mb-2">{{ $campaign->displayName() }}</h1>
                @if($campaign->name && $campaign->name !== $campaign->title)
                    <p class="text-gray-500 text-sm mb-1 italic">{{ $campaign->title }}</p>
                @endif
                @php $allUrls = $campaign->source_urls ?: [$campaign->source_url]; @endphp
                <div class="flex flex-col gap-1">
                    @foreach($allUrls as $u)
                    <a href="{{ $u }}" target="_blank" class="text-gray-400 text-sm hover:text-[#67EADD] transition-colors truncate max-w-lg">{{ $u }}</a>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                @if($campaign->status === 'published')
                    <a href="{{ route('generated.landing', $campaign->slug) }}" target="_blank"
                       class="border border-gray-600 hover:border-gray-400 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                        View landing page ↗
                    </a>
                    <a href="{{ route('generated.campaign', $campaign->slug) }}" target="_blank"
                       class="border border-gray-600 hover:border-gray-400 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                        View campaign brief ↗
                    </a>
                @else
                    <a href="{{ route('generated.landing', $campaign->slug) }}?preview=1" target="_blank"
                       class="border border-gray-600 hover:border-gray-400 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                        Preview landing ↗
                    </a>
                    <a href="{{ route('generated.campaign', $campaign->slug) }}?preview=1" target="_blank"
                       class="border border-gray-600 hover:border-gray-400 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                        Preview campaign ↗
                    </a>
                    <form method="POST" action="{{ route('make.publish', $campaign->id) }}">
                        @csrf
                        <button type="submit"
                                class="bg-[#67EADD] hover:bg-[#21DBC8] text-[#083763] font-semibold px-5 py-2 rounded-lg text-sm transition-colors">
                            Publish pages
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="bg-[#F4F2E3] py-16 px-6 lg:px-8">
    <div class="max-w-6xl mx-auto space-y-10">

        @if(session('success'))
        <div class="bg-[#E1FFEC] border border-[#B3FEF7] text-[#083763] px-5 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        {{-- Landing page content --}}
        <div class="bg-white rounded-2xl border border-[#E6E2D9] overflow-hidden">
            <div class="px-8 py-5 border-b border-[#E6E2D9] flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-[#67EADD]"></div>
                <h2 class="font-bold text-gray-900">Landing page</h2>
            </div>
            <div class="p-8 space-y-6">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Hero headline</p>
                    <p class="text-xl font-bold font-display text-gray-900">{{ $campaign->hero_headline }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Subheadline</p>
                    <p class="text-gray-600 leading-relaxed">{{ $campaign->hero_subheadline }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">{{ $campaign->framework_name }} — {{ $campaign->concepts->count() }} concepts</p>
                    <p class="text-gray-500 text-sm mb-4 italic">{{ $campaign->framework_intro }}</p>
                    <div class="space-y-2">
                        @foreach($campaign->concepts as $concept)
                        <div class="flex items-start gap-4 px-4 py-3 rounded-lg bg-gray-50 border border-gray-100">
                            <span class="text-sm font-bold text-[#67EADD] shrink-0 font-display">{{ $concept->number }}</span>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $concept->name }}</p>
                                <p class="text-gray-500 text-sm">{{ $concept->principle }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @if($campaign->context_headline)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Context / positioning</p>
                    <p class="font-semibold text-gray-900 mb-1">{{ $campaign->context_headline }}</p>
                    <p class="text-gray-500 text-sm">{{ $campaign->context_body }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Campaign packages --}}
        @php
            $packagesByPersona = $campaign->packages->groupBy('persona');
            $campaignPersonas  = $campaign->personas ?? ['enterprise_automation'];
            // Only show tabs for personas that have packages
            $activePersonaKeys = $packagesByPersona->keys()->toArray();
            $firstPersona      = $activePersonaKeys[0] ?? 'enterprise_automation';
            $hasMultiplePersonas = count($activePersonaKeys) > 1;
        @endphp

        <div x-data="{ persona: '{{ $firstPersona }}' }" class="bg-white rounded-2xl border border-[#E6E2D9] overflow-hidden">
            <div class="px-8 py-5 border-b border-[#E6E2D9]">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#1D60CA]"></div>
                        <h2 class="font-bold text-gray-900">Campaign packages</h2>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-400">
                        <span>{{ $campaign->packages->where('status', 'approved')->count() }} approved</span>
                        <span>·</span>
                        <span>{{ $campaign->packages->where('status', 'skipped')->count() }} skipped</span>
                        <span>·</span>
                        <span>{{ $campaign->packages->where('status', 'pending')->count() }} pending</span>
                    </div>
                </div>

                @if($hasMultiplePersonas)
                {{-- Persona tabs --}}
                <div class="flex gap-1 bg-gray-100 rounded-lg p-1 w-fit">
                    @foreach($activePersonaKeys as $pKey)
                        @php $pDef = $personaDefs[$pKey] ?? null; @endphp
                        @if($pDef)
                        <button @click="persona = '{{ $pKey }}'"
                                :class="persona === '{{ $pKey }}' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'"
                                class="text-xs font-medium px-3 py-1.5 rounded-md transition-all whitespace-nowrap">
                            {{ $pDef['label'] }}
                        </button>
                        @endif
                    @endforeach
                </div>
                @else
                    @php $pDef = $personaDefs[$firstPersona] ?? null; @endphp
                    @if($pDef)
                    <div class="inline-flex items-center gap-2 bg-[#E1FFEC] border border-[#B3FEF7] text-[#083763] text-xs font-semibold px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 bg-[#21DBC8] rounded-full"></span>
                        {{ $pDef['label'] }}
                    </div>
                    @endif
                @endif
            </div>

            @foreach($activePersonaKeys as $pKey)
            @php $personaPackages = $packagesByPersona[$pKey] ?? collect(); @endphp
            <div x-show="persona === '{{ $pKey }}'" class="divide-y divide-gray-100">
                @foreach($personaPackages as $package)
                <div x-data="{ open: false }" class="px-8 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4 flex-1 min-w-0">
                            <button @click="open = !open" class="text-left flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-xs font-semibold text-[#1D60CA] uppercase tracking-wider shrink-0">{{ $package->channelLabel() }}</span>
                                    @if($package->status === 'approved')
                                        <span class="text-xs bg-[#E1FFEC] text-[#083763] px-2 py-0.5 rounded-full font-medium">Approved</span>
                                    @elseif($package->status === 'skipped')
                                        <span class="text-xs bg-gray-100 text-gray-400 px-2 py-0.5 rounded-full font-medium">Skipped</span>
                                    @endif
                                </div>
                                <p class="font-semibold text-gray-900 text-sm truncate">{{ $package->title }}</p>
                                <p class="text-gray-400 text-sm mt-0.5 line-clamp-1">{{ Str::limit($package->copy, 100) }}</p>
                            </button>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <form method="POST" action="{{ route('make.package', [$campaign->id, $package->id]) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                        class="text-xs font-semibold px-3 py-1.5 rounded-lg border transition-colors {{ $package->status === 'approved' ? 'bg-[#E1FFEC] border-[#67EADD] text-[#083763]' : 'border-gray-200 text-gray-500 hover:border-[#67EADD] hover:text-[#083763]' }}">
                                    ✓ Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('make.package', [$campaign->id, $package->id]) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="skipped">
                                <button type="submit"
                                        class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-gray-200 text-gray-400 hover:border-red-300 hover:text-red-500 transition-colors">
                                    Skip
                                </button>
                            </form>
                            <button @click="open = !open"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-gray-200 text-gray-500 hover:border-gray-400 transition-colors">
                                <span x-text="open ? 'Collapse' : 'Read'">Read</span>
                            </button>
                        </div>
                    </div>

                    <div x-show="open" x-collapse class="mt-4">
                        <div class="bg-gray-50 rounded-xl p-5 font-mono-code text-sm text-gray-700 leading-relaxed whitespace-pre-wrap border border-gray-100">{{ $package->copy }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
