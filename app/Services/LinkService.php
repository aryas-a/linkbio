<?php

namespace App\Services;

use App\Models\Link;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LinkService
{
    /**
     * Create a new link
     */
    public function create(Profile $profile, array $data): Link
    {
        // Get the next position
        $maxPosition = $profile->links()->max('position') ?? -1;
        $data['position'] = $maxPosition + 1;
        $data['profile_id'] = $profile->id;

        return Link::create($data);
    }

    /**
     * Update a link
     */
    public function update(Link $link, array $data): Link
    {
        $link->update($data);
        $link->refresh();

        return $link;
    }

    /**
     * Delete a link
     */
    public function delete(Link $link): bool
    {
        return $link->delete();
    }

    /**
     * Reorder links
     */
    public function reorder(Profile $profile, array $linkIds): bool
    {
        return DB::transaction(function () use ($profile, $linkIds) {
            foreach ($linkIds as $position => $linkId) {
                $profile->links()
                    ->where('id', $linkId)
                    ->update(['position' => $position]);
            }

            return true;
        });
    }

    /**
     * Toggle link active status
     */
    public function toggleActive(Link $link): Link
    {
        $link->update(['is_active' => !$link->is_active]);
        $link->refresh();

        return $link;
    }

    /**
     * Duplicate a link
     */
    public function duplicate(Link $link): Link
    {
        $data = $link->toArray();
        unset($data['id'], $data['created_at'], $data['updated_at'], $data['deleted_at']);
        
        $data['title'] = $data['title'] . ' (Copy)';
        $data['position'] = $link->profile->links()->max('position') + 1;

        return Link::create($data);
    }

    /**
     * Get links for a profile with click counts
     */
    public function getWithClickCounts(Profile $profile): Collection
    {
        return $profile->links()
            ->withCount('clicks')
            ->orderBy('position')
            ->get();
    }

    /**
     * Get visible links for public profile
     */
    public function getVisibleLinks(Profile $profile): Collection
    {
        return $profile->links()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderBy('position')
            ->get();
    }

    /**
     * Check link limit for profile
     */
    public function canAddLink(Profile $profile): bool
    {
        $plan = $profile->user->currentPlan();
        
        if (!$plan) {
            // Free tier limit
            return $profile->links()->count() < 10;
        }

        if ($plan->max_links === -1) {
            return true;
        }

        return $profile->links()->count() < $plan->max_links;
    }

    /**
     * Bulk update links
     */
    public function bulkUpdate(Profile $profile, array $updates): bool
    {
        return DB::transaction(function () use ($profile, $updates) {
            foreach ($updates as $update) {
                if (isset($update['id'])) {
                    $profile->links()
                        ->where('id', $update['id'])
                        ->update(collect($update)->except('id')->toArray());
                }
            }

            return true;
        });
    }

    /**
     * Bulk delete links
     */
    public function bulkDelete(Profile $profile, array $linkIds): int
    {
        return $profile->links()
            ->whereIn('id', $linkIds)
            ->delete();
    }
}
