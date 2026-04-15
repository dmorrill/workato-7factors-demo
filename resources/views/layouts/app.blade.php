<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seven Factors of the Agentic Control Plane — Workato')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900"
      x-data="{
          modal: false,
          modalTitle: '',
          modalBody: '',
          openModal(title, body) {
              this.modalTitle = title;
              this.modalBody = body;
              this.modal = true;
          }
      }"
      @keydown.escape.window="modal = false">

    {{-- Modal --}}
    <div x-show="modal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4"
         style="display: none;">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="modal = false"></div>
        {{-- Card --}}
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 z-10"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-start justify-between mb-5">
                <div class="flex items-center gap-2">
                    <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">Mock</span>
                    <span class="text-gray-400 text-xs">Design concept — not live</span>
                </div>
                <button @click="modal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-3" x-text="modalTitle"></h3>
            <p class="text-gray-500 text-sm leading-relaxed" x-text="modalBody"></p>
            <button @click="modal = false"
                    class="mt-6 w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                Got it
            </button>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-10">
                    <a href="/" class="flex items-center gap-2 shrink-0">
                        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" rx="8" fill="#FF5F36"/>
                            <path d="M8 10h3.5l2.5 8 2.5-8h3l2.5 8 2.5-8H28l-4.5 12h-3l-2.5-7.5L15.5 22h-3L8 10z" fill="white"/>
                        </svg>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">workato</span>
                    </a>
                    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                        <a href="#" class="hover:text-gray-900 transition-colors"
                           @click.prevent="openModal('Platform', 'This would link to the main Workato platform overview — Enterprise MCP, Workato ONE, and the full integration and automation suite.')">Platform</a>
                        <a href="#" class="hover:text-gray-900 transition-colors"
                           @click.prevent="openModal('Agents', 'This would link to the Workato Agents product page — including Otto, the AI super-app for employees, and the agentic automation suite.')">Agents</a>
                        <a href="#" class="hover:text-gray-900 transition-colors"
                           @click.prevent="openModal('Solutions', 'This would link to the Workato solutions directory — use cases by industry, function, and integration type.')">Solutions</a>
                        <a href="#" class="hover:text-gray-900 transition-colors"
                           @click.prevent="openModal('Resources', 'This would link to the Workato resource library — documentation, blog, Academy curriculum, and developer guides.')">Resources</a>
                        <a href="#" class="hover:text-gray-900 transition-colors"
                           @click.prevent="openModal('Partners', 'This would link to the Workato partner ecosystem — system integrators, technology partners, and the marketplace.')">Partners</a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/campaign') }}" class="hidden md:block text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Campaign brief →</a>
                    <button @click="openModal('Get a trial', 'This would open the Workato Developer Sandbox signup — a free, permanent self-serve environment with 1,000+ connectors, 50K free credits, and AI automations. No credit card required.')"
                            class="bg-[#FF5F36] hover:bg-[#E54E27] text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors cursor-pointer">
                        Get a trial
                    </button>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    {{-- Footer --}}
    <footer class="bg-[#0D0F2B] text-gray-400 py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg width="22" height="22" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" rx="8" fill="#FF5F36"/>
                            <path d="M8 10h3.5l2.5 8 2.5-8h3l2.5 8 2.5-8H28l-4.5 12h-3l-2.5-7.5L15.5 22h-3L8 10z" fill="white"/>
                        </svg>
                        <span class="text-white font-bold text-lg tracking-tight">workato</span>
                    </div>
                    <p class="text-sm leading-relaxed">The modern leader in enterprise automation and agentic AI.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Framework</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-white transition-colors">The Seven Factors</a></li>
                        <li><button @click="openModal('White papers', 'This would open the Seven Factors white paper series — a PDF download of all seven deep-dive documents. Each covers architectural patterns, real-world examples, and implementation guidance for that factor. In production, gated behind a simple email capture.')" class="hover:text-white transition-colors text-left">White papers</button></li>
                        <li><button @click="openModal('Open source', 'This would link to the Dewy Resort GitHub repository — an open-source reference implementation showing the Seven Factors architectural patterns in action. Clone it, explore the patterns, and see how each factor is implemented in a real agentic system.')" class="hover:text-white transition-colors text-left">Open source</button></li>
                        <li><button @click="openModal('Contribute', 'This would link to the CONTRIBUTING.md on the Seven Factors GitHub repository. The framework is explicitly designed for community contributions — if your team has learned something building agentic systems in production that belongs here, the process for submitting it lives there.')" class="hover:text-white transition-colors text-left">Contribute</button></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm">
                        <li><button @click="openModal('Enterprise MCP', 'This would link to the Workato Enterprise MCP product page — production-ready Model Context Protocol servers that make SaaS products agent-ready. Partners include Anthropic, AWS, Atlassian, and Box.')" class="hover:text-white transition-colors text-left">Enterprise MCP</button></li>
                        <li><button @click="openModal('Developer Sandbox', 'This would link to the Workato Developer Sandbox signup — a free, permanent self-serve environment launched August 2025. Includes 1,000+ connectors, 50K free credits, AI automations, and MCP integrations.')" class="hover:text-white transition-colors text-left">Developer Sandbox</button></li>
                        <li><button @click="openModal('Workato ONE', 'This would link to the Workato ONE unified platform page — integration, orchestration, and AI agents in a single platform.')" class="hover:text-white transition-colors text-left">Workato ONE</button></li>
                        <li><button @click="openModal('Documentation', 'This would link to the Workato developer documentation — API references, integration guides, and the full SDK documentation.')" class="hover:text-white transition-colors text-left">Documentation</button></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Community</h4>
                    <ul class="space-y-2 text-sm">
                        <li><button @click="openModal('Developer community', 'This would link to the Workato developer community — forums, the DAB (Developer Advisory Board), community-built recipes, and the marketplace with 1M+ user-contributed automations.')" class="hover:text-white transition-colors text-left">Developer community</button></li>
                        <li><button @click="openModal('GitHub', 'This would link to the Workato GitHub organization — including Workato Labs, the Dewy Resort reference implementation, open-source tooling, and the Seven Factors framework repository.')" class="hover:text-white transition-colors text-left">GitHub</button></li>
                        <li><button @click="openModal('Events', 'This would link to the Workato events calendar — developer meetups, conference appearances, MCP dev summits, and community workshops.')" class="hover:text-white transition-colors text-left">Events</button></li>
                        <li><button @click="openModal('Blog', 'This would link to the Workato developer blog — including Zayne Turner\'s MCP content series and technical deep-dives on agentic architecture.')" class="hover:text-white transition-colors text-left">Blog</button></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm">© {{ date('Y') }} Workato, Inc. All rights reserved.</p>
                <p class="text-sm text-gray-500">This is a design concept for internal review.</p>
            </div>
        </div>
    </footer>

</body>
</html>
