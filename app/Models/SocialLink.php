<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLink extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'profile_id',
        'platform',
        'url',
        'position',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'position' => 'integer',
        ];
    }

    // Platform configurations
    public const PLATFORMS = [
        'instagram' => [
            'name' => 'Instagram',
            'icon' => 'instagram',
            'color' => '#E4405F',
            'pattern' => '/^https?:\/\/(www\.)?instagram\.com\/[a-zA-Z0-9_.]+\/?$/',
        ],
        'twitter' => [
            'name' => 'X (Twitter)',
            'icon' => 'twitter',
            'color' => '#000000',
            'pattern' => '/^https?:\/\/(www\.)?(twitter|x)\.com\/[a-zA-Z0-9_]+\/?$/',
        ],
        'youtube' => [
            'name' => 'YouTube',
            'icon' => 'youtube',
            'color' => '#FF0000',
            'pattern' => '/^https?:\/\/(www\.)?youtube\.com\/(c\/|channel\/|@)?[a-zA-Z0-9_-]+\/?$/',
        ],
        'tiktok' => [
            'name' => 'TikTok',
            'icon' => 'tiktok',
            'color' => '#000000',
            'pattern' => '/^https?:\/\/(www\.)?tiktok\.com\/@[a-zA-Z0-9_.]+\/?$/',
        ],
        'linkedin' => [
            'name' => 'LinkedIn',
            'icon' => 'linkedin',
            'color' => '#0A66C2',
            'pattern' => '/^https?:\/\/(www\.)?linkedin\.com\/in\/[a-zA-Z0-9_-]+\/?$/',
        ],
        'github' => [
            'name' => 'GitHub',
            'icon' => 'github',
            'color' => '#181717',
            'pattern' => '/^https?:\/\/(www\.)?github\.com\/[a-zA-Z0-9_-]+\/?$/',
        ],
        'whatsapp' => [
            'name' => 'WhatsApp',
            'icon' => 'whatsapp',
            'color' => '#25D366',
            'pattern' => '/^https?:\/\/(wa\.me|api\.whatsapp\.com)\/[0-9]+\/?$/',
        ],
        'facebook' => [
            'name' => 'Facebook',
            'icon' => 'facebook',
            'color' => '#1877F2',
            'pattern' => '/^https?:\/\/(www\.)?facebook\.com\/[a-zA-Z0-9.]+\/?$/',
        ],
        'twitch' => [
            'name' => 'Twitch',
            'icon' => 'twitch',
            'color' => '#9146FF',
            'pattern' => '/^https?:\/\/(www\.)?twitch\.tv\/[a-zA-Z0-9_]+\/?$/',
        ],
        'discord' => [
            'name' => 'Discord',
            'icon' => 'discord',
            'color' => '#5865F2',
            'pattern' => '/^https?:\/\/(www\.)?discord\.(gg|com\/invite)\/[a-zA-Z0-9]+\/?$/',
        ],
        'telegram' => [
            'name' => 'Telegram',
            'icon' => 'telegram',
            'color' => '#26A5E4',
            'pattern' => '/^https?:\/\/(t\.me|telegram\.me)\/[a-zA-Z0-9_]+\/?$/',
        ],
        'snapchat' => [
            'name' => 'Snapchat',
            'icon' => 'snapchat',
            'color' => '#FFFC00',
            'pattern' => '/^https?:\/\/(www\.)?snapchat\.com\/add\/[a-zA-Z0-9._-]+\/?$/',
        ],
        'pinterest' => [
            'name' => 'Pinterest',
            'icon' => 'pinterest',
            'color' => '#E60023',
            'pattern' => '/^https?:\/\/(www\.)?pinterest\.com\/[a-zA-Z0-9_]+\/?$/',
        ],
        'threads' => [
            'name' => 'Threads',
            'icon' => 'threads',
            'color' => '#000000',
            'pattern' => '/^https?:\/\/(www\.)?threads\.net\/@[a-zA-Z0-9_.]+\/?$/',
        ],
        'email' => [
            'name' => 'Email',
            'icon' => 'email',
            'color' => '#EA4335',
            'pattern' => '/^mailto:[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        ],
        'website' => [
            'name' => 'Website',
            'icon' => 'globe',
            'color' => '#6366F1',
            'pattern' => '/^https?:\/\/.+$/',
        ],
    ];

    // Relationships
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    // Helpers
    public function getPlatformConfig(): array
    {
        return self::PLATFORMS[$this->platform] ?? [
            'name' => ucfirst($this->platform),
            'icon' => 'link',
            'color' => '#6366F1',
            'pattern' => null,
        ];
    }

    public function getPlatformName(): string
    {
        return $this->getPlatformConfig()['name'];
    }

    public function getPlatformIcon(): string
    {
        return $this->getPlatformConfig()['icon'];
    }

    public function getPlatformColor(): string
    {
        return $this->getPlatformConfig()['color'];
    }

    public static function getPlatformOptions(): array
    {
        return collect(self::PLATFORMS)->map(fn ($config) => $config['name'])->toArray();
    }
}
