<x-layouts.dashboard :header="'Dashboard'">
    <div class="space-y-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="stat-label">Total Views</p>
                        <p class="stat-value">{{ number_format($overview['total_views']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-surface-400 mt-2">
                    <span class="text-accent-400">+{{ number_format($overview['views_today']) }}</span> today
                </p>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="stat-label">Total Clicks</p>
                        <p class="stat-value">{{ number_format($overview['total_clicks']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-surface-400 mt-2">
                    <span class="text-accent-400">+{{ number_format($overview['clicks_today']) }}</span> today
                </p>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="stat-label">Views (30 days)</p>
                        <p class="stat-value">{{ number_format($overview['views_period']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="stat-label">Click Rate</p>
                        <p class="stat-value">{{ $overview['ctr'] }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-rose-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('dashboard.links') }}" class="flex flex-col items-center p-4 bg-surface-800/50 rounded-xl hover:bg-surface-700/50 transition-colors">
                    <div class="w-10 h-10 bg-primary-500/20 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-sm text-surface-300">Add Link</span>
                </a>
                <a href="{{ route('dashboard.appearance') }}" class="flex flex-col items-center p-4 bg-surface-800/50 rounded-xl hover:bg-surface-700/50 transition-colors">
                    <div class="w-10 h-10 bg-accent-500/20 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <span class="text-sm text-surface-300">Customize</span>
                </a>
                <a href="{{ route('dashboard.analytics') }}" class="flex flex-col items-center p-4 bg-surface-800/50 rounded-xl hover:bg-surface-700/50 transition-colors">
                    <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-surface-300">Analytics</span>
                </a>
                <a href="{{ route('profile.show', $profile->username) }}" target="_blank" class="flex flex-col items-center p-4 bg-surface-800/50 rounded-xl hover:bg-surface-700/50 transition-colors">
                    <div class="w-10 h-10 bg-rose-500/20 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </div>
                    <span class="text-sm text-surface-300">View Profile</span>
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Weekly Views Chart -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Views (Last 7 Days)</h2>
                <div class="h-48 flex items-end gap-2">
                    @php
                        $maxViews = $dailyViews->max('count') ?: 1;
                    @endphp
                    @foreach($dailyViews as $day)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary-500/20 rounded-t-lg transition-all hover:bg-primary-500/30"
                             style="height: {{ max(($day['count'] / $maxViews) * 100, 5) }}%">
                        </div>
                        <span class="text-xs text-surface-500">{{ \Carbon\Carbon::parse($day['date'])->format('D') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Links -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Top Links</h2>
                @if($topLinks->count() > 0)
                <div class="space-y-3">
                    @foreach($topLinks as $link)
                    <div class="flex items-center justify-between p-3 bg-surface-800/50 rounded-lg">
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-medium truncate">{{ $link->title }}</p>
                            <p class="text-surface-500 text-sm truncate">{{ $link->url }}</p>
                        </div>
                        <div class="ml-4 text-right">
                            <p class="text-white font-medium">{{ number_format($link->clicks_count) }}</p>
                            <p class="text-surface-500 text-sm">clicks</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-surface-400">
                    <p>No links yet. Add your first link to get started!</p>
                    <a href="{{ route('dashboard.links') }}" class="btn-primary mt-4 inline-block">Add Link</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Profile URL -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Your Profile URL</h2>
            <div class="flex items-center gap-4 flex-wrap">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 p-3 bg-surface-800 rounded-lg">
                        <span class="text-surface-400 truncate">{{ url('/') }}/</span>
                        <span class="text-white font-medium">{{ $profile->username }}</span>
                    </div>
                </div>
                <button onclick="navigator.clipboard.writeText('{{ $profile->getUrl() }}'); this.textContent = 'Copied!';"
                        class="btn-secondary shrink-0">
                    Copy Link
                </button>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
