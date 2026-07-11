<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    public const DEFAULT_HEADER_TITLE = 'HUT RI ke-81 Kabupaten Konawe';
    public const DEFAULT_FOOTER_TITLE = 'HUT RI ke-81 Kabupaten Konawe';
    public const DEFAULT_REGISTRATION_CLOSED_MESSAGE = 'Pendaftaran lomba saat ini belum dibuka atau telah ditutup.';
    public const DEFAULT_HEADER_KONAWE_LOGO = 'assets/logo/logo_konawe.png';
    public const DEFAULT_HEADER_HUTRI_LOGO = 'assets/logo/hutri81-symbol.png';
    public const DEFAULT_HERO_LOGO = 'assets/logo/hutri81-full-red.png';
    public const REGISTRATION_OPEN = 'open';
    public const REGISTRATION_CLOSED = 'closed';
    public const REGISTRATION_HIDDEN = 'hidden';

    protected $fillable = [
        'registration_enabled',
        'registration_status',
        'registration_closed_message',
        'header_title',
        'footer_title',
        'header_konawe_logo_path',
        'header_hutri_logo_path',
        'hero_logo_path',
    ];

    protected function casts(): array
    {
        return [
            'registration_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        if (! Schema::hasTable('site_settings')) {
            return new self([
                'registration_enabled' => true,
                'registration_status' => self::REGISTRATION_OPEN,
                'registration_closed_message' => self::DEFAULT_REGISTRATION_CLOSED_MESSAGE,
                'header_title' => self::DEFAULT_HEADER_TITLE,
                'footer_title' => self::DEFAULT_FOOTER_TITLE,
            ]);
        }

        return self::query()->firstOrCreate([], self::defaultAttributes());
    }

    private static function defaultAttributes(): array
    {
        $defaults = [
            'registration_enabled' => true,
            'registration_status' => self::REGISTRATION_OPEN,
            'registration_closed_message' => self::DEFAULT_REGISTRATION_CLOSED_MESSAGE,
        ];

        if (Schema::hasColumn('site_settings', 'header_title')) {
            $defaults['header_title'] = self::DEFAULT_HEADER_TITLE;
        }

        if (Schema::hasColumn('site_settings', 'footer_title')) {
            $defaults['footer_title'] = self::DEFAULT_FOOTER_TITLE;
        }

        return $defaults;
    }

    public static function registrationEnabled(): bool
    {
        return self::current()->isRegistrationOpen();
    }

    public function registrationStatus(): string
    {
        if (! Schema::hasColumn('site_settings', 'registration_status')) {
            return $this->registration_enabled ? self::REGISTRATION_OPEN : self::REGISTRATION_HIDDEN;
        }

        return $this->registration_status ?: ($this->registration_enabled ? self::REGISTRATION_OPEN : self::REGISTRATION_HIDDEN);
    }

    public function isRegistrationOpen(): bool
    {
        return $this->registrationStatus() === self::REGISTRATION_OPEN;
    }

    public function isRegistrationClosed(): bool
    {
        return $this->registrationStatus() === self::REGISTRATION_CLOSED;
    }

    public function isRegistrationHidden(): bool
    {
        return $this->registrationStatus() === self::REGISTRATION_HIDDEN;
    }

    public function shouldShowRegistrationMenu(): bool
    {
        return ! $this->isRegistrationHidden();
    }

    public function closedMessage(): string
    {
        return $this->registration_closed_message ?: self::DEFAULT_REGISTRATION_CLOSED_MESSAGE;
    }

    public function headerTitle(): string
    {
        return $this->columnValue('header_title') ?: self::DEFAULT_HEADER_TITLE;
    }

    public function footerTitle(): string
    {
        return $this->columnValue('footer_title') ?: self::DEFAULT_FOOTER_TITLE;
    }

    public function headerKonaweLogoUrl(): string
    {
        return asset($this->columnValue('header_konawe_logo_path') ?: self::DEFAULT_HEADER_KONAWE_LOGO);
    }

    public function headerHutriLogoUrl(): string
    {
        return asset($this->columnValue('header_hutri_logo_path') ?: self::DEFAULT_HEADER_HUTRI_LOGO);
    }

    public function heroLogoUrl(): string
    {
        return asset($this->columnValue('hero_logo_path') ?: self::DEFAULT_HERO_LOGO);
    }

    private function columnValue(string $column): ?string
    {
        if (! Schema::hasColumn('site_settings', $column)) {
            return null;
        }

        return $this->{$column};
    }
}
