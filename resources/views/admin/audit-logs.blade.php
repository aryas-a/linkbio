<x-layouts.admin :header="'Audit Logs'">
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-surface-400 text-sm border-b border-surface-800 bg-surface-800/50">
                        <th class="px-6 py-4 font-medium">Time</th>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Action</th>
                        <th class="px-6 py-4 font-medium">Description</th>
                        <th class="px-6 py-4 font-medium">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-800">
                    @forelse($logs as $log)
                    <tr class="hover:bg-surface-800/30">
                        <td class="px-6 py-4 text-surface-400 text-sm">{{ $log->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 text-white">{{ $log->user?->email ?? 'System' }}</td>
                        <td class="px-6 py-4">
                            <span class="badge badge-primary">{{ $log->action }}</span>
                        </td>
                        <td class="px-6 py-4 text-surface-300">{{ $log->description ?? '-' }}</td>
                        <td class="px-6 py-4 text-surface-400 text-sm">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-surface-400">No audit logs</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $logs->links() }}
    </div>
</x-layouts.admin>
