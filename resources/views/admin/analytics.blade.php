<x-layouts.admin :header="'Platform Analytics'">
    <div class="space-y-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card">
                <p class="stat-label">New Profiles ({{ $days }}d)</p>
                <p class="stat-value">{{ number_format($stats['new_profiles']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Views ({{ $days }}d)</p>
                <p class="stat-value">{{ number_format($stats['views_period']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Clicks ({{ $days }}d)</p>
                <p class="stat-value">{{ number_format($stats['clicks_period']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Links</p>
                <p class="stat-value">{{ number_format($stats['total_links']) }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="?days=7" class="px-4 py-2 text-sm {{ $days == 7 ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300' }} rounded-lg">7 days</a>
            <a href="?days=30" class="px-4 py-2 text-sm {{ $days == 30 ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300' }} rounded-lg">30 days</a>
            <a href="?days=90" class="px-4 py-2 text-sm {{ $days == 90 ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300' }} rounded-lg">90 days</a>
        </div>
    </div>
</x-layouts.admin>
