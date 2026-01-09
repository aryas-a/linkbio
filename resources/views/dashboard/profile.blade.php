<x-layouts.dashboard :header="'Profile Settings'">
    <div class="max-w-2xl space-y-8">
        <!-- Profile Image -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-6">Profile Image</h2>
            <div class="flex items-center gap-6">
                @if($profile->profile_image)
                <img src="{{ $profile->profile_image }}" alt="{{ $profile->display_name }}"
                     class="w-24 h-24 rounded-full object-cover ring-4 ring-surface-700">
                @else
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-3xl text-white ring-4 ring-surface-700">
                    {{ strtoupper(substr($profile->display_name, 0, 1)) }}
                </div>
                @endif
                <form action="{{ route('dashboard.profile.image') }}" method="POST" enctype="multipart/form-data" class="flex-1">
                    @csrf
                    <input type="file" name="profile_image" accept="image/*" required
                           class="block w-full text-sm text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-500 file:text-white hover:file:bg-primary-400 cursor-pointer">
                    <p class="text-surface-500 text-xs mt-2">Max 2MB. JPG, PNG, GIF, or WebP.</p>
                    <button type="submit" class="btn-secondary mt-4 text-sm">Upload Image</button>
                </form>
            </div>
        </div>

        <!-- Profile Info -->
        <form action="{{ route('dashboard.profile.update') }}" method="POST" class="glass-card p-6 space-y-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-white">Profile Information</h2>

            <div class="form-group">
                <label for="username" class="input-label">Username</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-surface-500">{{ url('/') }}/</span>
                    <input type="text" id="username" name="username" value="{{ $profile->username }}"
                           class="input-field pl-36" pattern="[a-z0-9_]+" minlength="3" maxlength="50">
                </div>
            </div>

            <div class="form-group">
                <label for="display_name" class="input-label">Display Name</label>
                <input type="text" id="display_name" name="display_name" value="{{ $profile->display_name }}"
                       class="input-field" maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="bio" class="input-label">Bio</label>
                <textarea id="bio" name="bio" rows="3" maxlength="500"
                          class="input-field resize-none" placeholder="Tell your audience about yourself...">{{ $profile->bio }}</textarea>
                <p class="text-surface-500 text-xs mt-1"><span x-text="(document.getElementById('bio')?.value || '').length">{{ strlen($profile->bio ?? '') }}</span>/500</p>
            </div>

            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ $profile->is_published ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-surface-600 bg-surface-800 text-primary-500">
                    <span class="text-surface-300">Profile is public</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
