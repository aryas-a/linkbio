<x-layouts.marketing>
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-accent-500/20 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500/10 border border-primary-500/30 rounded-full text-primary-300 text-sm mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                        </span>
                        Now in public beta
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                        One link for
                        <span class="bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">
                            everything
                        </span>
                        you share
                    </h1>

                    <p class="text-lg sm:text-xl text-surface-300 mb-8 max-w-xl mx-auto lg:mx-0">
                        Create a personalized link-in-bio page in minutes. Share all your important links, social profiles, and content in one beautiful place.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                            Get Started Free
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="{{ route('features') }}" class="btn-secondary text-lg px-8 py-4">
                            See Features
                        </a>
                    </div>

                    <p class="text-surface-500 text-sm mt-6">No credit card required • Free forever plan</p>
                </div>

                <!-- Demo Preview -->
                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative w-72 sm:w-80">
                        <!-- Phone Frame -->
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500 to-accent-500 rounded-[3rem] blur-xl opacity-30 animate-glow"></div>
                        <div class="relative bg-surface-900 rounded-[2.5rem] p-3 shadow-2xl border border-surface-700">
                            <div class="bg-gradient-to-br from-primary-900 via-surface-900 to-accent-900 rounded-[2rem] overflow-hidden">
                                <!-- Status Bar -->
                                <div class="flex justify-center pt-3 pb-2">
                                    <div class="w-20 h-5 bg-surface-800 rounded-full"></div>
                                </div>

                                <!-- Profile Content -->
                                <div class="px-6 pb-8 text-center">
                                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-primary-400 to-accent-400 p-1">
                                        <div class="w-full h-full rounded-full bg-surface-800 flex items-center justify-center text-2xl">
                                            👋
                                        </div>
                                    </div>
                                    <h3 class="text-white font-bold text-lg">@yourname</h3>
                                    <p class="text-surface-400 text-sm mt-1">Digital Creator & Designer</p>

                                    <!-- Social Icons -->
                                    <div class="flex justify-center gap-3 mt-4">
                                        <div class="w-8 h-8 bg-surface-700 rounded-full"></div>
                                        <div class="w-8 h-8 bg-surface-700 rounded-full"></div>
                                        <div class="w-8 h-8 bg-surface-700 rounded-full"></div>
                                        <div class="w-8 h-8 bg-surface-700 rounded-full"></div>
                                    </div>

                                    <!-- Links -->
                                    <div class="space-y-3 mt-6">
                                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-xl font-medium text-sm">
                                            🎨 My Portfolio
                                        </div>
                                        <div class="bg-surface-700 text-white py-3 px-4 rounded-xl font-medium text-sm">
                                            📧 Contact Me
                                        </div>
                                        <div class="bg-surface-700 text-white py-3 px-4 rounded-xl font-medium text-sm">
                                            🎬 YouTube Channel
                                        </div>
                                        <div class="bg-surface-700 text-white py-3 px-4 rounded-xl font-medium text-sm">
                                            📸 Latest Work
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-surface-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                    Everything you need
                </h2>
                <p class="text-lg text-surface-400 max-w-2xl mx-auto">
                    Powerful features to help you grow your online presence
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card p-6 hover:border-primary-500/50 transition-colors">
                    <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Custom Themes</h3>
                    <p class="text-surface-400">Customize colors, fonts, backgrounds, and button styles to match your brand.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card p-6 hover:border-primary-500/50 transition-colors">
                    <div class="w-12 h-12 bg-accent-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Analytics</h3>
                    <p class="text-surface-400">Track views, clicks, and audience insights to understand your traffic.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card p-6 hover:border-primary-500/50 transition-colors">
                    <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Mobile First</h3>
                    <p class="text-surface-400">Perfectly optimized for mobile devices where your audience lives.</p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card p-6 hover:border-primary-500/50 transition-colors">
                    <div class="w-12 h-12 bg-rose-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Unlimited Links</h3>
                    <p class="text-surface-400">Add as many links as you need. No artificial limits on free plans.</p>
                </div>

                <!-- Feature 5 -->
                <div class="glass-card p-6 hover:border-primary-500/50 transition-colors">
                    <div class="w-12 h-12 bg-cyan-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Social Integration</h3>
                    <p class="text-surface-400">Connect all your social profiles with beautiful icons and easy access.</p>
                </div>

                <!-- Feature 6 -->
                <div class="glass-card p-6 hover:border-primary-500/50 transition-colors">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">SEO Optimized</h3>
                    <p class="text-surface-400">Custom meta tags, OG images, and fast loading for better rankings.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                Ready to create your page?
            </h2>
            <p class="text-lg text-surface-400 mb-8">
                Join thousands of creators who trust LinkBio for their online presence.
            </p>
            <a href="{{ route('register') }}" class="btn-primary text-lg px-10 py-4">
                Get Started Free
            </a>
        </div>
    </section>
</x-layouts.marketing>
