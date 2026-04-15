<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seven Factors of the Agentic Control Plane — Workato')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    {{-- Navigation --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-10">
                    {{-- Workato wordmark --}}
                    <a href="/" class="flex items-center gap-2 shrink-0">
                        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" rx="8" fill="#FF5F36"/>
                            <path d="M8 10h3.5l2.5 8 2.5-8h3l2.5 8 2.5-8H28l-4.5 12h-3l-2.5-7.5L15.5 22h-3L8 10z" fill="white"/>
                        </svg>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">workato</span>
                    </a>
                    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                        <a href="#" class="hover:text-gray-900 transition-colors">Platform</a>
                        <a href="#" class="hover:text-gray-900 transition-colors">Agents</a>
                        <a href="#" class="hover:text-gray-900 transition-colors">Solutions</a>
                        <a href="#" class="hover:text-gray-900 transition-colors">Resources</a>
                        <a href="#" class="hover:text-gray-900 transition-colors">Partners</a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/campaign') }}" class="hidden md:block text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Campaign brief →</a>
                    <a href="#" class="bg-[#FF5F36] hover:bg-[#E54E27] text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Get a trial</a>
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
                        <li><a href="#" class="hover:text-white transition-colors">The Seven Factors</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">White papers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Open source</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contribute</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Enterprise MCP</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Developer Sandbox</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Workato ONE</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Community</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Developer community</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">GitHub</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Events</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
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
