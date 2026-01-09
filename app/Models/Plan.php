<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'billing_cycle',
        'features',
        'max_links',
        'max_social_links',
        'custom_themes',
        'remove_branding',
        'custom_domain',
        'advanced_analytics',
        'priority_support',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'features' => 'array',
            'max_links' => 'integer',
            'max_social_links' => 'integer',
            'custom_themes' => 'boolean',
            'remove_branding' => 'boolean',
            'custom_domain' => 'boolean',
            'advanced_analytics' => 'boolean',
            'priority_support' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Relationships
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    // Helpers
    public function isFree(): bool
    {
        return $this->price <= 0;
    }

    public function getMonthlyPrice(): float
    {
        if ($this->billing_cycle === 'yearly') {
            return round($this->price / 12, 2);
        }

        return (float) $this->price;
    }

    public function getFormattedPrice(): string
    {
        if ($this->isFree()) {
            return 'Free';
        }

        $price = number_format($this->price, 2);
        $cycle = $this->billing_cycle === 'lifetime' ? '' : "/{$this->billing_cycle}";

        return "\${$price}{$cycle}";
    }

    public function getFeatureList(): array
    {
        $features = [];

        $features[] = $this->max_links === -1 ? 'Unlimited links' : "{$this->max_links} links";
        $features[] = $this->max_social_links === -1 ? 'All social links' : "{$this->max_social_links} social links";

        if ($this->custom_themes) {
            $features[] = 'Custom themes';
        }

        if ($this->remove_branding) {
            $features[] = 'Remove branding';
        }

        if ($this->custom_domain) {
            $features[] = 'Custom domain';
        }

        if ($this->advanced_analytics) {
            $features[] = 'Advanced analytics';
        }

        if ($this->priority_support) {
            $features[] = 'Priority support';
        }

        if ($this->features) {
            $features = array_merge($features, $this->features);
        }

        return $features;
    }
}
