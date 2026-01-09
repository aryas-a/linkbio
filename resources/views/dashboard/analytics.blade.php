<x-layouts.dashboard :header="'Analytics'">
    <div class="space-y-8">
        <!-- Period Selector -->
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white">Analytics Overview</h2>
            <div class="flex gap-2">
                <a href="?days=7" class="px-4 py-2 text-sm {{ $days == 7 ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300 hover:text-white' }} rounded-lg transition-colors">7 days</a>
                <a href="?days=30" class="px-4 py-2 text-sm {{ $days == 30 ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300 hover:text-white' }} rounded-lg transition-colors">30 days</a>
                <a href="?days=90" class="px-4 py-2 text-sm {{ $days == 90 ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300 hover:text-white' }} rounded-lg transition-colors">90 days</a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card">
                <p class="stat-label">Total Views</p>
                <p class="stat-value">{{ number_format($overview['total_views']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Clicks</p>
                <p class="stat-value">{{ number_format($overview['total_clicks']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Period Views</p>
                <p class="stat-value">{{ number_format($overview['views_period']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Click Rate</p>
                <p class="stat-value">{{ $overview['ctr'] }}%</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Views Chart -->
            <div class="glass-card p-6">
                <h3 class="text-white font-medium mb-4">Profile Views</h3>
                <div class="h-48 flex items-end gap-1">
                    @php $maxViews = $dailyViews->max('count') ?: 1; @endphp
                    @foreach($dailyViews as $day)
                    <div class="flex-1 bg-primary-500/30 rounded-t hover:bg-primary-500/50 transition-colors"
                         style="height: {{ max(($day['count'] / $maxViews) * 100, 2) }}%"
                         title="{{ $day['date'] }}: {{ $day['count'] }} views"></div>
                    @endforeach
                </div>
            </div>

            <!-- Clicks Chart -->
            <div class="glass-card p-6">
                <h3 class="text-white font-medium mb-4">Link Clicks</h3>
                <div class="h-48 flex items-end gap-1">
                    @php $maxClicks = $dailyClicks->max('count') ?: 1; @endphp
                    @foreach($dailyClicks as $day)
                    <div class="flex-1 bg-accent-500/30 rounded-t hover:bg-accent-500/50 transition-colors"
                         style="height: {{ max(($day['count'] / $maxClicks) * 100, 2) }}%"
                         title="{{ $day['date'] }}: {{ $day['count'] }} clicks"></div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Links & Breakdown -->
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Top Links -->
            <div class="glass-card p-6">
                <h3 class="text-white font-medium mb-4">Top Links</h3>
                @if($topLinks->count() > 0)
                <div class="space-y-3">
                    @foreach($topLinks as $link)
                    <div class="flex items-center gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-white truncate">{{ $link->title }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-medium">{{ number_format($link->clicks_count) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-surface-400">No clicks yet</p>
                @endif
            </div>

            <!-- Device Breakdown -->
            <div class="glass-card p-6">
                <h3 class="text-white font-medium mb-4">Devices</h3>
                @if($deviceBreakdown->count() > 0)
                <div class="space-y-3">
                    @foreach($deviceBreakdown as $device)
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <p class="text-white capitalize">{{ $device['device'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-medium">{{ number_format($device['count']) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-surface-400">No data yet</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.dashboard>
