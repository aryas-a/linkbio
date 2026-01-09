<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'profile_id',
        'title',
        'url',
        'icon',
        'position',
        'is_active',
        'open_new_tab',
        'scheduled_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'open_new_tab' => 'boolean',
            'scheduled_at' => 'datetime',
            'expires_at' => 'datetime',
            'position' => 'integer',
        ];
    }

    // Relationships
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(LinkClick::class);
    }

    // Helpers
    public function isVisible(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->scheduled_at && $this->scheduled_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function getTarget(): string
    {
        return $this->open_new_tab ? '_blank' : '_self';
    }

    public function getRel(): string
    {
        return $this->open_new_tab ? 'noopener noreferrer' : '';
    }

    public function clickCount(): int
    {
        return $this->clicks()->count();
    }

    public function clicksToday(): int
    {
        return $this->clicks()
            ->whereDate('clicked_at', today())
            ->count();
    }

    public function clicksThisWeek(): int
    {
        return $this->clicks()
            ->whereBetween('clicked_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
    }

    public function getIconClass(): string
    {
        if (!$this->icon) {
            return 'link';
        }

        return $this->icon;
    }
}
