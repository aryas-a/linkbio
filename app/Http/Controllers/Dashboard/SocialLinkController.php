<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSocialLinkRequest;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    /**
     * Show social links management page
     */
    public function index(Request $request): View
    {
        $profile = $request->user()->profile;
        $socialLinks = $profile->socialLinks()->orderBy('position')->get();
        $availablePlatforms = $this->getAvailablePlatforms($profile);

        return view('dashboard.social-links', compact('profile', 'socialLinks', 'availablePlatforms'));
    }

    /**
     * Store a new social link
     */
    public function store(StoreSocialLinkRequest $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        $maxPosition = $profile->socialLinks()->max('position') ?? -1;

        $profile->socialLinks()->create([
            ...$request->validated(),
            'position' => $maxPosition + 1,
        ]);

        return back()->with('success', 'Social link added!');
    }

    /**
     * Update a social link
     */
    public function update(Request $request, SocialLink $socialLink): RedirectResponse
    {
        // Authorization check
        if ($socialLink->profile->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'url' => 'required|url|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        $socialLink->update($validated);

        return back()->with('success', 'Social link updated!');
    }

    /**
     * Delete a social link
     */
    public function destroy(Request $request, SocialLink $socialLink): RedirectResponse
    {
        // Authorization check
        if ($socialLink->profile->user_id !== $request->user()->id) {
            abort(403);
        }

        $socialLink->delete();

        return back()->with('success', 'Social link deleted!');
    }

    /**
     * Reorder social links
     */
    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'social_links' => 'required|array',
            'social_links.*' => 'uuid|exists:social_links,id',
        ]);

        $profile = $request->user()->profile;

        foreach ($request->input('social_links') as $position => $id) {
            $profile->socialLinks()
                ->where('id', $id)
                ->update(['position' => $position]);
        }

        return back()->with('success', 'Social links reordered!');
    }

    /**
     * Get available platforms (not yet added)
     */
    protected function getAvailablePlatforms($profile): array
    {
        $usedPlatforms = $profile->socialLinks()->pluck('platform')->toArray();
        
        return collect(SocialLink::PLATFORMS)
            ->filter(fn ($config, $platform) => !in_array($platform, $usedPlatforms))
            ->map(fn ($config, $platform) => [
                'value' => $platform,
                'label' => $config['name'],
                'icon' => $config['icon'],
            ])
            ->values()
            ->toArray();
    }
}
