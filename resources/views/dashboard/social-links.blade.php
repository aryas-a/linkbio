<x-layouts.dashboard :header="'Social Links'">
    <div class="max-w-2xl space-y-6">
        <!-- Add Social Link -->
        @if(count($availablePlatforms) > 0)
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Add Social Link</h2>
            <form action="{{ route('dashboard.social.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="input-label">Platform</label>
                        <select name="platform" required class="input-field">
                            <option value="">Select platform...</option>
                            @foreach($availablePlatforms as $platform)
                            <option value="{{ $platform['value'] }}">{{ $platform['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="input-label">Profile URL</label>
                        <input type="url" name="url" required class="input-field" placeholder="https://...">
                    </div>
                </div>
                <button type="submit" class="btn-primary">Add Social Link</button>
            </form>
        </div>
        @endif

        <!-- Social Links List -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Your Social Links</h2>
            
            @if($socialLinks->count() > 0)
            <div class="space-y-3">
                @foreach($socialLinks as $social)
                <div class="flex items-center gap-4 p-4 bg-surface-800/50 rounded-xl group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center"
                         style="background-color: {{ $social->getPlatformColor() }}20; color: {{ $social->getPlatformColor() }}">
                        @include('partials.social-icons.' . $social->platform, ['class' => 'w-5 h-5'])
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-medium">{{ $social->getPlatformName() }}</p>
                        <p class="text-surface-500 text-sm truncate">{{ $social->url }}</p>
                    </div>
                    <form action="{{ route('dashboard.social.destroy', $social) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-surface-400 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-surface-400">
                <p>No social links yet. Add your first one above!</p>
            </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
