<x-layouts.admin :header="'Users'">
    <div class="space-y-6">
        <!-- Search & Filter -->
        <div class="flex flex-wrap gap-4">
            <form method="GET" class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                       class="input-field">
            </form>
            <div class="flex gap-2">
                <a href="?status=active" class="px-4 py-2 text-sm {{ request('status') === 'active' ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300' }} rounded-lg">Active</a>
                <a href="?status=suspended" class="px-4 py-2 text-sm {{ request('status') === 'suspended' ? 'bg-primary-500 text-white' : 'bg-surface-800 text-surface-300' }} rounded-lg">Suspended</a>
                <a href="{{ route('admin.users') }}" class="px-4 py-2 text-sm bg-surface-800 text-surface-300 rounded-lg">All</a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-surface-400 text-sm border-b border-surface-800 bg-surface-800/50">
                            <th class="px-6 py-4 font-medium">User</th>
                            <th class="px-6 py-4 font-medium">Username</th>
                            <th class="px-6 py-4 font-medium">Role</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium">Joined</th>
                            <th class="px-6 py-4 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-800">
                        @forelse($users as $user)
                        <tr class="hover:bg-surface-800/30">
                            <td class="px-6 py-4 text-white">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->profile)
                                <a href="{{ route('profile.show', $user->profile->username) }}" target="_blank" class="text-primary-400 hover:underline">
                                    {{ $user->profile->username }}
                                </a>
                                @else
                                <span class="text-surface-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->isAdmin())
                                <span class="badge badge-primary">Admin</span>
                                @else
                                <span class="badge bg-surface-700 text-surface-300">User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Suspended</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-surface-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-primary-400 hover:text-primary-300 text-sm">View</a>
                                    @if(!$user->isAdmin())
                                        @if($user->is_active)
                                        <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm" onclick="return confirm('Suspend this user?')">Suspend</button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-accent-400 hover:text-accent-300 text-sm">Activate</button>
                                        </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-surface-400">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $users->links() }}
        </div>
    </div>
</x-layouts.admin>
