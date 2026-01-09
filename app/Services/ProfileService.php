<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileService
{
    /**
     * Create a new profile for a user
     */
    public function create(User $user, array $data): Profile
    {
        $data['user_id'] = $user->id;
        $data['username'] = $this->generateUniqueUsername($data['username'] ?? $user->email);

        return Profile::create($data);
    }

    /**
     * Update profile data
     */
    public function update(Profile $profile, array $data): Profile
    {
        // Handle username change
        if (isset($data['username']) && $data['username'] !== $profile->username) {
            $data['username'] = $this->generateUniqueUsername($data['username'], $profile->id);
        }

        $profile->update($data);
        $profile->refresh();

        return $profile;
    }

    /**
     * Upload profile image
     */
    public function uploadProfileImage(Profile $profile, UploadedFile $file): string
    {
        // Delete old image if exists
        if ($profile->profile_image) {
            $this->deleteImage($profile->profile_image);
        }

        $path = $this->uploadImage($file, 'profiles/avatars');
        
        $profile->update(['profile_image' => $path]);

        return $path;
    }

    /**
     * Upload background image
     */
    public function uploadBackgroundImage(Profile $profile, UploadedFile $file): string
    {
        // Delete old image if exists
        if ($profile->background_image) {
            $this->deleteImage($profile->background_image);
        }

        $path = $this->uploadImage($file, 'profiles/backgrounds');
        
        $profile->update([
            'background_image' => $path,
            'background_type' => 'image',
        ]);

        return $path;
    }

    /**
     * Upload OG image
     */
    public function uploadOgImage(Profile $profile, UploadedFile $file): string
    {
        // Delete old image if exists
        if ($profile->og_image) {
            $this->deleteImage($profile->og_image);
        }

        $path = $this->uploadImage($file, 'profiles/og');
        
        $profile->update(['og_image' => $path]);

        return $path;
    }

    /**
     * Get profile by username (cached)
     */
    public function getByUsername(string $username): ?Profile
    {
        return Cache::remember(
            "profile:{$username}",
            now()->addHours(1),
            function () use ($username) {
                return Profile::with(['activeLinks', 'activeSocialLinks'])
                    ->where('username', $username)
                    ->where('is_published', true)
                    ->first();
            }
        );
    }

    /**
     * Generate a unique username
     */
    protected function generateUniqueUsername(string $base, ?string $excludeId = null): string
    {
        // Clean the base username
        $username = Str::slug($base, '');
        $username = preg_replace('/[^a-z0-9_]/', '', strtolower($username));
        $username = substr($username, 0, 45);

        if (empty($username)) {
            $username = 'user';
        }

        // Check if unique
        $query = Profile::where('username', $username);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if (!$query->exists()) {
            return $username;
        }

        // Add suffix until unique
        $suffix = 1;
        while (true) {
            $newUsername = $username . $suffix;
            
            $query = Profile::where('username', $newUsername);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                return $newUsername;
            }

            $suffix++;
        }
    }

    /**
     * Upload an image file
     */
    protected function uploadImage(UploadedFile $file, string $directory): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');

        return Storage::url($path);
    }

    /**
     * Delete an image file
     */
    protected function deleteImage(string $path): bool
    {
        // Extract the relative path from the URL
        $relativePath = str_replace('/storage/', '', $path);
        
        if (Storage::disk('public')->exists($relativePath)) {
            return Storage::disk('public')->delete($relativePath);
        }

        return false;
    }

    /**
     * Check if username is available
     */
    public function isUsernameAvailable(string $username, ?string $excludeId = null): bool
    {
        $query = Profile::where('username', $username);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }

    /**
     * Get reserved usernames
     */
    public static function getReservedUsernames(): array
    {
        return [
            'admin', 'api', 'auth', 'login', 'logout', 'register',
            'dashboard', 'settings', 'profile', 'user', 'users',
            'help', 'support', 'contact', 'about', 'terms', 'privacy',
            'pricing', 'features', 'blog', 'docs', 'documentation',
            'app', 'home', 'index', 'root', 'null', 'undefined',
            'static', 'assets', 'images', 'css', 'js', 'public',
        ];
    }
}
