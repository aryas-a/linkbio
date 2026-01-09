<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Profile extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'username',
        'display_name',
        'bio',
        'profile_image',
        'background_image',
        'background_type',
        'background_color',
        'gradient_start',
        'gradient_end',
        'gradient_direction',
        'theme',
        'font_family',
        'button_style',
        'button_color',
        'button_text_color',
        'text_color',
        'seo_title',
        'seo_description',
        'og_image',
        'is_published',
        'hide_branding',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'hide_branding' => 'boolean',
        ];
    }

    // Cache key for this profile
    public function cacheKey(): string
    {
        return "profile:{$this->username}";
    }

    // Clear cache when profile is updated
    protected static function booted(): void
    {
        static::updated(function (Profile $profile) {
            Cache::forget($profile->cacheKey());
        });

        static::deleted(function (Profile $profile) {
            Cache::forget($profile->cacheKey());
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class)->orderBy('position');
    }

    public function activeLinks(): HasMany
    {
        return $this->hasMany(Link::class)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderBy('position');
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('position');
    }

    public function activeSocialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)
            ->where('is_active', true)
            ->orderBy('position');
    }

    public function views(): HasMany
    {
        return $this->hasMany(ProfileView::class);
    }

    // Helpers
    public function getUrl(): string
    {
        return url("/{$this->username}");
    }

    public function getBackgroundStyle(): string
    {
        return match ($this->background_type) {
            'solid' => "background-color: {$this->background_color};",
            'gradient' => "background: linear-gradient({$this->getGradientDirection()}, {$this->gradient_start}, {$this->gradient_end});",
            'image' => $this->background_image 
                ? "background-image: url('{$this->background_image}'); background-size: cover; background-position: center;"
                : "background-color: {$this->background_color};",
            default => "background-color: #0f0f23;",
        };
    }

    public function getGradientDirection(): string
    {
        return match ($this->gradient_direction) {
            'to-r' => 'to right',
            'to-l' => 'to left',
            'to-t' => 'to top',
            'to-b' => 'to bottom',
            'to-tr' => 'to top right',
            'to-tl' => 'to top left',
            'to-br' => 'to bottom right',
            'to-bl' => 'to bottom left',
            default => 'to bottom right',
        };
    }

    public function getButtonClasses(): string
    {
        return match ($this->button_style) {
            'rounded' => 'rounded-xl',
            'pill' => 'rounded-full',
            'square' => 'rounded-none',
            'soft' => 'rounded-lg',
            default => 'rounded-xl',
        };
    }

    public function getMetaTitle(): string
    {
        return $this->seo_title ?: "{$this->display_name} | LinkBio";
    }

    public function getMetaDescription(): string
    {
        return $this->seo_description ?: ($this->bio ?: "Check out {$this->display_name}'s links");
    }

    public function getOgImage(): ?string
    {
        return $this->og_image ?: $this->profile_image;
    }

    public function viewCount(): int
    {
        return Cache::remember(
            "{$this->cacheKey()}:views",
            now()->addMinutes(5),
            fn () => $this->views()->count()
        );
    }

    public function clickCount(): int
    {
        return Cache::remember(
            "{$this->cacheKey()}:clicks",
            now()->addMinutes(5),
            fn () => $this->links()->withCount('clicks')->get()->sum('clicks_count')
        );
    }
}
