<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileView extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'ip_hash',
        'user_agent',
        'referrer',
        'country',
        'device_type',
        'browser',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
        ];
    }

    // Relationships
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    // Helpers
    public static function recordView(Profile $profile, string $ip, ?string $userAgent = null, ?string $referrer = null): self
    {
        $deviceType = self::detectDeviceType($userAgent);
        $browser = self::detectBrowser($userAgent);

        return self::create([
            'profile_id' => $profile->id,
            'ip_hash' => hash('sha256', $ip . config('app.key')),
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'referrer' => $referrer ? substr($referrer, 0, 500) : null,
            'device_type' => $deviceType,
            'browser' => $browser,
            'viewed_at' => now(),
        ]);
    }

    public static function detectDeviceType(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'unknown';
        }

        $userAgent = strtolower($userAgent);

        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/(mobile|iphone|ipod|android|blackberry|opera mini|iemobile)/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    public static function detectBrowser(?string $userAgent): ?string
    {
        if (!$userAgent) {
            return null;
        }

        $browsers = [
            'Edge' => '/edg/i',
            'Chrome' => '/chrome/i',
            'Safari' => '/safari/i',
            'Firefox' => '/firefox/i',
            'Opera' => '/opera|opr/i',
            'IE' => '/msie|trident/i',
        ];

        foreach ($browsers as $browser => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                // Chrome check needs to exclude Edge
                if ($browser === 'Chrome' && preg_match('/edg/i', $userAgent)) {
                    continue;
                }
                // Safari check needs to exclude Chrome
                if ($browser === 'Safari' && preg_match('/chrome/i', $userAgent)) {
                    continue;
                }
                return $browser;
            }
        }

        return null;
    }
}
