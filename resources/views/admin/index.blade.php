<x-layouts.admin :header="'Admin Dashboard'">
    <div class="space-y-8">
        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card">
                <p class="stat-label">Total Profiles</p>
                <p class="stat-value">{{ number_format($stats['total_profiles']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Links</p>
                <p class="stat-value">{{ number_format($stats['total_links']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Views</p>
                <p class="stat-value">{{ number_format($stats['total_views']) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Clicks</p>
                <p class="stat-value">{{ number_format($stats['total_clicks']) }}</p>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-white">Recent Users</h2>
                <a href="{{ route('admin.users') }}" class="text-primary-400 hover:text-primary-300 text-sm">View all →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-surface-400 text-sm border-b border-surface-800">
                            <th class="pb-3 font-medium">User</th>
                            <th class="pb-3 font-medium">Username</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-800">
                        @foreach($recentUsers as $user)
                        <tr class="hover:bg-surface-800/50">
                            <td class="py-3 text-white">{{ $user->email }}</td>
                            <td class="py-3 text-surface-300">{{ $user->profile?->username ?? '-' }}</td>
                            <td class="py-3">
                                @if($user->is_active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Suspended</span>
                                @endif
                            </td>
                            <td class="py-3 text-surface-400">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
