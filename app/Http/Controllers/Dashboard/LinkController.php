<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function __construct(
        protected LinkService $linkService
    ) {}

    /**
     * Show links management page
     */
    public function index(Request $request): View
    {
        $profile = $request->user()->profile;
        $links = $this->linkService->getWithClickCounts($profile);
        $canAddLink = $this->linkService->canAddLink($profile);

        return view('dashboard.links', compact('profile', 'links', 'canAddLink'));
    }

    /**
     * Store a new link
     */
    public function store(StoreLinkRequest $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        if (!$this->linkService->canAddLink($profile)) {
            return back()->withErrors(['limit' => 'You have reached your link limit. Upgrade to add more links.']);
        }

        $this->linkService->create($profile, $request->validated());

        return back()->with('success', 'Link added successfully!');
    }

    /**
     * Update a link
     */
    public function update(UpdateLinkRequest $request, Link $link): RedirectResponse
    {
        $this->authorize('update', $link);

        $this->linkService->update($link, $request->validated());

        return back()->with('success', 'Link updated!');
    }

    /**
     * Delete a link
     */
    public function destroy(Request $request, Link $link): RedirectResponse
    {
        $this->authorize('delete', $link);

        $this->linkService->delete($link);

        return back()->with('success', 'Link deleted!');
    }

    /**
     * Toggle link active status
     */
    public function toggle(Request $request, Link $link): RedirectResponse
    {
        $this->authorize('update', $link);

        $this->linkService->toggleActive($link);

        return back()->with('success', 'Link status updated!');
    }

    /**
     * Reorder links
     */
    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'links' => 'required|array',
            'links.*' => 'uuid|exists:links,id',
        ]);

        $profile = $request->user()->profile;
        $this->linkService->reorder($profile, $request->input('links'));

        return back()->with('success', 'Links reordered!');
    }

    /**
     * Duplicate a link
     */
    public function duplicate(Request $request, Link $link): RedirectResponse
    {
        $this->authorize('update', $link);

        $profile = $request->user()->profile;

        if (!$this->linkService->canAddLink($profile)) {
            return back()->withErrors(['limit' => 'You have reached your link limit.']);
        }

        $this->linkService->duplicate($link);

        return back()->with('success', 'Link duplicated!');
    }
}
