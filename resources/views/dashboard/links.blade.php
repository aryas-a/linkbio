<x-layouts.dashboard :header="'Links'">
    <div class="space-y-6">
        <!-- Add Link Form -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Add New Link</h2>
            
            @if(!$canAddLink)
            <div class="p-4 bg-amber-500/20 border border-amber-500/50 text-amber-300 rounded-xl mb-4">
                You've reached your link limit. Upgrade to add more links.
            </div>
            @endif

            <form action="{{ route('dashboard.links.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="title" class="input-label">Title</label>
                        <input type="text" id="title" name="title" required maxlength="100"
                               class="input-field" placeholder="My Website" {{ !$canAddLink ? 'disabled' : '' }}>
                    </div>
                    <div class="form-group">
                        <label for="url" class="input-label">URL</label>
                        <input type="url" id="url" name="url" required
                               class="input-field" placeholder="https://example.com" {{ !$canAddLink ? 'disabled' : '' }}>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="open_new_tab" value="1" checked {{ !$canAddLink ? 'disabled' : '' }}
                               class="w-4 h-4 rounded border-surface-600 bg-surface-800 text-primary-500">
                        <span class="text-sm text-surface-300">Open in new tab</span>
                    </label>
                    <button type="submit" class="btn-primary ml-auto" {{ !$canAddLink ? 'disabled' : '' }}>
                        Add Link
                    </button>
                </div>
            </form>
        </div>

        <!-- Links List -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Your Links</h2>

            @if($links->count() > 0)
            <div class="space-y-3" x-data="{ dragging: null }">
                @foreach($links as $link)
                <div class="flex items-center gap-4 p-4 bg-surface-800/50 rounded-xl group hover:bg-surface-800 transition-colors"
                     x-data="{ editing: false }">
                    <!-- Drag Handle -->
                    <div class="text-surface-500 cursor-grab hover:text-surface-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                        </svg>
                    </div>

                    <!-- Link Info -->
                    <div class="flex-1 min-w-0" x-show="!editing">
                        <div class="flex items-center gap-2">
                            <p class="text-white font-medium truncate">{{ $link->title }}</p>
                            @if(!$link->is_active)
                            <span class="badge badge-warning">Disabled</span>
                            @endif
                        </div>
                        <p class="text-surface-500 text-sm truncate">{{ $link->url }}</p>
                    </div>

                    <!-- Edit Form (inline) -->
                    <form x-show="editing" x-cloak action="{{ route('dashboard.links.update', $link) }}" method="POST" class="flex-1 flex items-center gap-4">
                        @csrf
                        @method('PUT')
                        <input type="text" name="title" value="{{ $link->title }}" class="input-field flex-1" placeholder="Title">
                        <input type="url" name="url" value="{{ $link->url }}" class="input-field flex-1" placeholder="URL">
                        <button type="submit" class="btn-primary text-sm py-2">Save</button>
                        <button type="button" @click="editing = false" class="btn-ghost text-sm py-2">Cancel</button>
                    </form>

                    <!-- Stats -->
                    <div class="text-right" x-show="!editing">
                        <p class="text-white font-medium">{{ number_format($link->clicks_count) }}</p>
                        <p class="text-surface-500 text-sm">clicks</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity" x-show="!editing">
                        <!-- Toggle -->
                        <form action="{{ route('dashboard.links.toggle', $link) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-surface-400 hover:text-white" title="{{ $link->is_active ? 'Disable' : 'Enable' }}">
                                @if($link->is_active)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                                @endif
                            </button>
                        </form>

                        <!-- Edit -->
                        <button @click="editing = true" class="p-2 text-surface-400 hover:text-white" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>

                        <!-- Delete -->
                        <form action="{{ route('dashboard.links.destroy', $link) }}" method="POST" onsubmit="return confirm('Delete this link?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-surface-400 hover:text-red-400" title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 text-surface-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-surface-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <p class="text-lg mb-2">No links yet</p>
                <p class="text-sm">Add your first link using the form above</p>
            </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
