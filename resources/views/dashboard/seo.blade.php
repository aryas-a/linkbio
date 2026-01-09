<x-layouts.dashboard :header="'SEO Settings'">
    <div class="max-w-2xl space-y-8">
        <!-- SEO Settings -->
        <form action="{{ route('dashboard.seo.update') }}" method="POST" class="glass-card p-6 space-y-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-white">Search Engine Optimization</h2>

            <div class="form-group">
                <label for="seo_title" class="input-label">Page Title</label>
                <input type="text" id="seo_title" name="seo_title" value="{{ $profile->seo_title }}"
                       class="input-field" maxlength="100" placeholder="{{ $profile->display_name }}">
                <p class="text-surface-500 text-xs mt-1">Appears in search results and browser tabs</p>
            </div>

            <div class="form-group">
                <label for="seo_description" class="input-label">Meta Description</label>
                <textarea id="seo_description" name="seo_description" rows="3" maxlength="300"
                          class="input-field resize-none" placeholder="A brief description of your profile...">{{ $profile->seo_description }}</textarea>
                <p class="text-surface-500 text-xs mt-1">Appears in search results (recommended: 150-160 characters)</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>

        <!-- OG Image -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Social Share Image</h2>
            <p class="text-surface-400 text-sm mb-6">This image appears when your profile is shared on social media.</p>

            @if($profile->og_image)
            <div class="mb-6">
                <img src="{{ $profile->og_image }}" alt="OG Image Preview" class="w-full max-w-md rounded-lg border border-surface-700">
            </div>
            @endif

            <form action="{{ route('dashboard.seo.og-image') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="og_image" accept="image/jpeg,image/png,image/jpg" required
                       class="block w-full text-sm text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-500 file:text-white hover:file:bg-primary-400 cursor-pointer">
                <p class="text-surface-500 text-xs mt-2">Recommended: 1200x630 pixels. Max 2MB. JPG or PNG.</p>
                <button type="submit" class="btn-secondary mt-4 text-sm">Upload Image</button>
            </form>
        </div>

        <!-- Preview -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Preview</h2>
            <div class="bg-surface-800 rounded-xl p-4">
                <p class="text-primary-400 text-sm mb-1">{{ $profile->getUrl() }}</p>
                <p class="text-white font-medium">{{ $profile->getMetaTitle() }}</p>
                <p class="text-surface-400 text-sm mt-1">{{ Str::limit($profile->getMetaDescription(), 160) }}</p>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
