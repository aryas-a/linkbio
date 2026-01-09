<x-layouts.dashboard :header="'Appearance'">
    <div class="max-w-4xl space-y-8">
        <form action="{{ route('dashboard.appearance.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Background Settings -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-6">Background</h2>
                
                <div class="space-y-6" x-data="{ backgroundType: '{{ $profile->background_type }}' }">
                    <!-- Background Type -->
                    <div class="grid grid-cols-3 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="background_type" value="solid" x-model="backgroundType" class="sr-only peer">
                            <div class="p-4 border-2 border-surface-700 rounded-xl text-center peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-colors">
                                <div class="w-8 h-8 mx-auto mb-2 rounded bg-gradient-to-br from-surface-700 to-surface-800"></div>
                                <span class="text-white text-sm">Solid Color</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="background_type" value="gradient" x-model="backgroundType" class="sr-only peer">
                            <div class="p-4 border-2 border-surface-700 rounded-xl text-center peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-colors">
                                <div class="w-8 h-8 mx-auto mb-2 rounded bg-gradient-to-br from-primary-500 to-accent-500"></div>
                                <span class="text-white text-sm">Gradient</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="background_type" value="image" x-model="backgroundType" class="sr-only peer">
                            <div class="p-4 border-2 border-surface-700 rounded-xl text-center peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-colors">
                                <div class="w-8 h-8 mx-auto mb-2 rounded bg-surface-700 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-white text-sm">Image</span>
                            </div>
                        </label>
                    </div>

                    <!-- Solid Color -->
                    <div x-show="backgroundType === 'solid'" class="form-group">
                        <label class="input-label">Background Color</label>
                        <div class="flex items-center gap-4">
                            <input type="color" name="background_color" value="{{ $profile->background_color }}"
                                   class="w-12 h-12 rounded-lg cursor-pointer bg-transparent border-0">
                            <input type="text" value="{{ $profile->background_color }}" 
                                   class="input-field flex-1" readonly>
                        </div>
                    </div>

                    <!-- Gradient -->
                    <div x-show="backgroundType === 'gradient'" class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="input-label">Start Color</label>
                                <div class="flex items-center gap-4">
                                    <input type="color" name="gradient_start" value="{{ $profile->gradient_start ?? '#8b5cf6' }}"
                                           class="w-12 h-12 rounded-lg cursor-pointer bg-transparent border-0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="input-label">End Color</label>
                                <div class="flex items-center gap-4">
                                    <input type="color" name="gradient_end" value="{{ $profile->gradient_end ?? '#06b6d4' }}"
                                           class="w-12 h-12 rounded-lg cursor-pointer bg-transparent border-0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="input-label">Direction</label>
                            <select name="gradient_direction" class="input-field">
                                <option value="to-br" {{ $profile->gradient_direction === 'to-br' ? 'selected' : '' }}>Bottom Right</option>
                                <option value="to-b" {{ $profile->gradient_direction === 'to-b' ? 'selected' : '' }}>Bottom</option>
                                <option value="to-r" {{ $profile->gradient_direction === 'to-r' ? 'selected' : '' }}>Right</option>
                                <option value="to-tr" {{ $profile->gradient_direction === 'to-tr' ? 'selected' : '' }}>Top Right</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Styles -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-6">Button Style</h2>
                
                <div class="space-y-6">
                    <!-- Button Shape -->
                    <div class="grid grid-cols-4 gap-4">
                        @foreach(['rounded' => 'Rounded', 'pill' => 'Pill', 'square' => 'Square', 'soft' => 'Soft'] as $value => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="button_style" value="{{ $value }}" 
                                   {{ $profile->button_style === $value ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="p-3 border-2 border-surface-700 rounded-xl text-center peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-colors">
                                <div class="h-6 mx-auto mb-2 bg-primary-500 {{ $value === 'rounded' ? 'rounded-xl' : ($value === 'pill' ? 'rounded-full' : ($value === 'square' ? 'rounded-none' : 'rounded-lg')) }}"></div>
                                <span class="text-white text-xs">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <!-- Colors -->
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label class="input-label">Button Color</label>
                            <input type="color" name="button_color" value="{{ $profile->button_color }}"
                                   class="w-full h-12 rounded-lg cursor-pointer bg-transparent border border-surface-700">
                        </div>
                        <div class="form-group">
                            <label class="input-label">Button Text</label>
                            <input type="color" name="button_text_color" value="{{ $profile->button_text_color }}"
                                   class="w-full h-12 rounded-lg cursor-pointer bg-transparent border border-surface-700">
                        </div>
                        <div class="form-group">
                            <label class="input-label">Text Color</label>
                            <input type="color" name="text_color" value="{{ $profile->text_color }}"
                                   class="w-full h-12 rounded-lg cursor-pointer bg-transparent border border-surface-700">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Font -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-6">Typography</h2>
                
                <div class="form-group">
                    <label class="input-label">Font Family</label>
                    <select name="font_family" class="input-field">
                        @foreach(['Inter', 'DM Sans', 'Poppins', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Nunito'] as $font)
                        <option value="{{ $font }}" {{ $profile->font_family === $font ? 'selected' : '' }}>{{ $font }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
