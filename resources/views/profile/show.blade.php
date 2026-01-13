<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- SEO -->
    <title>{{ $profile->getMetaTitle() }}</title>
    <meta name="description" content="{{ $profile->getMetaDescription() }}">
    <link rel="canonical" href="{{ $profile->getUrl() }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $profile->getMetaTitle() }}">
    <meta property="og:description" content="{{ $profile->getMetaDescription() }}">
    <meta property="og:type" content="profile">
    <meta property="og:url" content="{{ $profile->getUrl() }}">
    @if($profile->getOgImage())
    <meta property="og:image" content="{{ $profile->getOgImage() }}">
    @endif
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $profile->getMetaTitle() }}">
    <meta name="twitter:description" content="{{ $profile->getMetaDescription() }}">
    @if($profile->getOgImage())
    <meta name="twitter:image" content="{{ $profile->getOgImage() }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family={{ urlencode($profile->font_family) }}:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: '{{ $profile->font_family }}', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen" style="{{ $profile->getBackgroundStyle() }}">
    <div class="min-h-screen flex flex-col items-center px-4 py-12 sm:py-16">
        <div class="w-full max-w-md space-y-6">
            <!-- Profile Header -->
            <div class="text-center">
                <!-- Profile Image -->
                @if($profile->profile_image)
                <img src="{{ $profile->profile_image }}" alt="{{ $profile->display_name }}"
                     class="w-24 h-24 sm:w-28 sm:h-28 rounded-full mx-auto mb-4 object-cover ring-4 ring-white/20 shadow-xl">
                @else
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full mx-auto mb-4 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-3xl ring-4 ring-white/20 shadow-xl">
                    {{ strtoupper(substr($profile->display_name, 0, 1)) }}
                </div>
                @endif

                <!-- Name & Bio -->
                <h1 class="text-xl sm:text-2xl font-bold mb-2" style="color: {{ $profile->text_color }}">
                    {{ $profile->display_name }}
                </h1>
                @if($profile->bio)
                <p class="text-sm sm:text-base opacity-80 max-w-sm mx-auto" style="color: {{ $profile->text_color }}">
                    {{ $profile->bio }}
                </p>
                @endif
            </div>

            <!-- Social Links -->
            @if($profile->activeSocialLinks->count() > 0)
            <div class="flex justify-center gap-3 flex-wrap">
                @foreach($profile->activeSocialLinks as $social)
                <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 rounded-full flex items-center justify-center transition-transform hover:scale-110"
                   style="background-color: {{ $social->getPlatformColor() }}20; color: {{ $social->getPlatformColor() }}"
                   title="{{ $social->getPlatformName() }}">
                    @includeFirst([
                        'partials.social-icons.' . $social->getPlatformIcon(),
                        'partials.social-icons.link'
                    ], ['class' => 'w-5 h-5'])
                </a>
                @endforeach
            </div>
            @endif

            <!-- Links -->
            <div class="space-y-3">
                @foreach($profile->activeLinks as $link)
                <a href="{{ route('link.click', $link) }}" 
                   target="{{ $link->getTarget() }}" 
                   rel="{{ $link->getRel() }}"
                   class="link-button {{ $profile->getButtonClasses() }}"
                   style="background-color: {{ $profile->button_color }}; color: {{ $profile->button_text_color }}">
                    {{ $link->title }}
                </a>
                @endforeach
            </div>

            <!-- Branding -->
            @if(!$profile->hide_branding)
            <div class="pt-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm opacity-60 hover:opacity-100 transition-opacity"
                   style="color: {{ $profile->text_color }}">
                    <div class="w-5 h-5 rounded bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <span>Made with LinkBio</span>
                </a>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
