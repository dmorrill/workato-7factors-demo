@extends('layouts.app')

@section('title', 'New Campaign — Campaign Maker · Workato')

@section('content')

<section class="bg-hero-dark text-white py-16 px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('make.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white text-sm mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            All campaigns
        </a>
        <h1 class="text-3xl font-bold font-display mb-3">New campaign</h1>
        <p class="text-gray-300">Give it one or more URLs — a framework page, a keynote video, a blog post — and it generates a landing page and full campaign brief.</p>
    </div>
</section>

<section class="bg-[#F4F2E3] py-16 px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

        <div x-data="{
                loading: false,
                urls: {{ json_encode(old('urls', [''])) }},
                addUrl() { this.urls.push('') },
                removeUrl(i) { this.urls.splice(i, 1) }
             }">
            <form method="POST" action="{{ route('make.store') }}" @submit="loading = true">
                @csrf

                <div class="bg-white rounded-2xl border border-[#E6E2D9] p-8 mb-6 space-y-6">

                    {{-- Campaign name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Campaign name
                            <span class="font-normal text-gray-400 ml-1">optional</span>
                        </label>
                        <input type="text" name="name"
                               placeholder="e.g. MCP Enterprise Launch Q2"
                               value="{{ old('name') }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#67EADD] focus:border-transparent transition-all">
                        <p class="text-gray-400 text-xs mt-2">Internal label for this campaign. If left blank, the generated page title is used.</p>
                    </div>

                    {{-- URLs --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Anchor content URLs</label>
                        <p class="text-gray-400 text-xs mb-4">Add one or more URLs. Web pages and YouTube videos are both supported. Content from all URLs is combined before generation.</p>

                        <div class="space-y-3">
                            <template x-for="(url, index) in urls" :key="index">
                                <div class="flex items-center gap-2">
                                    <input type="url"
                                           :name="'urls[' + index + ']'"
                                           x-model="urls[index]"
                                           required
                                           :placeholder="index === 0 ? 'https://workato.com/7factors  or  https://youtube.com/watch?v=...' : 'https://...'"
                                           class="flex-1 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#67EADD] focus:border-transparent transition-all">
                                    <button type="button"
                                            x-show="urls.length > 1"
                                            @click="removeUrl(index)"
                                            class="shrink-0 w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:border-red-300 hover:text-red-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        @error('urls')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                        @error('urls.*')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror

                        <button type="button" @click="addUrl()"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-[#1D60CA] hover:text-[#083763] transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add another URL
                        </button>
                    </div>
                </div>

                {{-- Persona selection --}}
                <div class="bg-white rounded-2xl border border-[#E6E2D9] p-8 mb-6">
                    <h2 class="font-bold text-gray-900 mb-1">Target developer personas</h2>
                    <p class="text-gray-400 text-xs mb-5">Select one or more. Each persona gets its own copy — toggle between them in the campaign brief.</p>

                    @php
                        $personaDefs = \App\Services\CampaignGeneratorService::personaDefinitions();
                        $groups = [];
                        foreach ($personaDefs as $key => $def) {
                            $groups[$def['group']][] = ['key' => $key, 'label' => $def['label'], 'audience' => $def['audience']];
                        }
                    @endphp

                    <div class="space-y-4 mb-4">
                        @foreach ($groups as $groupName => $groupPersonas)
                        <div class="rounded-xl border border-gray-200 overflow-hidden">
                            <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $groupName }}</p>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @foreach ($groupPersonas as $persona)
                                <label class="flex items-start gap-3 px-4 py-3 cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox"
                                           name="personas[]"
                                           value="{{ $persona['key'] }}"
                                           {{ in_array($persona['key'], old('personas', ['enterprise_automation'])) ? 'checked' : '' }}
                                           class="mt-0.5 w-4 h-4 rounded border-gray-300 text-[#083763] focus:ring-[#67EADD]">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $persona['label'] }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $persona['audience'] }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-gray-400 text-xs">Each additional persona adds ~20–30 seconds to generation time.</p>
                </div>

                {{-- What gets generated --}}
                <div class="bg-[#E1FFEC] border border-[#B3FEF7] rounded-xl p-5 text-sm text-[#083763] mb-6">
                    <p class="font-semibold mb-2">What gets generated</p>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <p class="font-medium mb-1">Landing page</p>
                            <ul class="text-xs space-y-1 text-[#083763]/70">
                                <li>· Hero headline + subheadline</li>
                                <li>· Framework name + concept list</li>
                                <li>· Context + positioning section</li>
                                <li>· Community CTA</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-medium mb-1">Campaign brief (6 packages per persona)</p>
                            <ul class="text-xs space-y-1 text-[#083763]/70">
                                <li>· Blog post draft</li>
                                <li>· LinkedIn + Twitter/X</li>
                                <li>· Newsletter blurb</li>
                                <li>· Video script + Developer tutorial</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('make.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">Cancel</a>
                    <button type="submit"
                            :disabled="loading"
                            class="bg-[#083763] hover:bg-[#0C3A70] text-white font-semibold px-8 py-3 rounded-lg text-sm transition-colors disabled:opacity-60 disabled:cursor-not-allowed flex items-center gap-2">
                        <span x-show="!loading">Generate campaign</span>
                        <span x-show="loading" x-cloak class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
                            Extracting &amp; generating...
                        </span>
                    </button>
                </div>

            </form>

            {{-- Full-screen loading overlay --}}
            <div x-show="loading" x-cloak
                 class="fixed inset-0 bg-[#083763]/90 backdrop-blur-sm z-50 flex flex-col items-center justify-center gap-6">
                <svg class="animate-spin w-12 h-12 text-[#67EADD]" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                <div class="text-center">
                    <p class="text-white font-semibold text-lg mb-1">Generating your campaign</p>
                    <p class="text-gray-400 text-sm">Extracting content, calling Claude, writing copy…<br>This takes about 20–30 seconds.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
