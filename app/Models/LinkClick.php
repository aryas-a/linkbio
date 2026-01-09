<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkClick extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'link_id',
        'ip_hash',
        'user_agent',
        'referrer',
        'country',
        'device_type',
        'clicked_at',
    ];

    protected function casts(): array
    {
        return [
            'clicked_at' => 'datetime',
        ];
    }

    // Relationships
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    // Helpers
    public static function recordClick(Link $link, string $ip, ?string $userAgent = null, ?string $referrer = null): self
    {
        $deviceType = ProfileView::detectDeviceType($userAgent);

        return self::create([
            'link_id' => $link->id,
            'ip_hash' => hash('sha256', $ip . config('app.key')),
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'referrer' => $referrer ? substr($referrer, 0, 500) : null,
            'device_type' => $deviceType,
            'clicked_at' => now(),
        ]);
    }
}
