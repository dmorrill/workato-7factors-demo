@extends('layouts.app')

@section('title', 'Campaign Maker — Workato')

@section('content')

<section class="bg-hero-dark text-white py-16 px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="inline-flex items-center gap-2 bg-[#0C3A70] border border-gray-700 rounded-full px-4 py-2 text-sm text-gray-300 mb-8">
            <span class="w-2 h-2 bg-[#67EADD] rounded-full"></span>
            Internal tool · WS1 Content Amplification
        </div>
        <div class="flex items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-bold font-display mb-3">Campaign Maker</h1>
                <p class="text-gray-300 text-lg max-w-2xl">Give it a URL — a piece of anchor content, a keynote, a framework page — and it generates a landing page and full campaign brief ready for review.</p>
            </div>
            <a href="{{ route('make.create') }}"
               class="shrink-0 bg-[#67EADD] hover:bg-[#21DBC8] text-[#083763] font-semibold px-6 py-3 rounded-lg transition-colors text-sm">
                + New campaign
            </a>
        </div>
    </div>
</section>

<section class="bg-[#F4F2E3] py-16 px-6 lg:px-8 min-h-64">
    <div class="max-w-5xl mx-auto">

        @if($campaigns->isEmpty())
        <div class="text-center py-20">
            <div class="w-16 h-16 rounded-2xl bg-[#E6E2D9] flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-gray-600 font-semibold mb-2">No campaigns yet</p>
            <p class="text-gray-400 text-sm mb-6">Paste a URL to generate your first landing page and campaign brief.</p>
            <a href="{{ route('make.create') }}" class="bg-[#083763] text-white font-semibold px-6 py-2.5 rounded-lg text-sm hover:bg-[#0C3A70] transition-colors">
                Create first campaign
            </a>
        </div>
        @else
        <div class="space-y-3">
            @foreach($campaigns as $campaign)
            <a href="{{ route('make.show', $campaign->id) }}"
               class="flex items-center gap-5 bg-white rounded-xl border border-[#E6E2D9] px-6 py-4 hover:border-[#67EADD] hover:shadow-sm transition-all group">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1">
                        <p class="font-semibold text-gray-900 truncate">{{ $campaign->displayName() }}</p>
                        <span class="shrink-0 text-xs font-medium px-2 py-0.5 rounded-full {{ $campaign->status === 'published' ? 'bg-[#E1FFEC] text-[#083763]' : 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                    @php $urlCount = count($campaign->source_urls ?? [$campaign->source_url]); @endphp
                    <p class="text-gray-400 text-sm truncate">
                        {{ $campaign->source_url }}
                        @if($urlCount > 1)
                            <span class="text-gray-300 ml-1">+{{ $urlCount - 1 }} more</span>
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-4 shrink-0 text-sm text-gray-400">
                    @if($campaign->status === 'published')
                    <a href="{{ route('generated.landing', $campaign->slug) }}" target="_blank"
                       class="hover:text-[#083763] transition-colors" onclick="event.stopPropagation()">
                        Landing →
                    </a>
                    <a href="{{ route('generated.campaign', $campaign->slug) }}" target="_blank"
                       class="hover:text-[#083763] transition-colors" onclick="event.stopPropagation()">
                        Campaign →
                    </a>
                    @endif
                    <span>{{ $campaign->created_at->format('M j') }}</span>
                    <svg class="w-4 h-4 group-hover:text-[#67EADD] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</section>

@endsection
