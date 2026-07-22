<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'starts_at',
        'ends_at',
        'registration_deadline',
        'venue',
        'quota',
        'is_open',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'registration_deadline' => 'datetime',
            'is_open' => 'boolean',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function operators(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'operator');
    }

    public function getScheduleText(): string
    {
        if (!$this->starts_at) return 'Menyusul';
        
        $startText = $this->starts_at->translatedFormat('d F Y H:i');
        
        $noEndTime = !$this->ends_at || $this->ends_at->format('H:i:s') === '23:59:59';
        
        if ($noEndTime) {
            if ($this->ends_at && !$this->starts_at->isSameDay($this->ends_at)) {
                return $startText . ' WITA - ' . $this->ends_at->translatedFormat('d F Y') . ' Selesai';
            }
            return $startText . ' WITA - Selesai';
        }

        if ($this->starts_at->isSameDay($this->ends_at)) {
            return $startText . ' WITA - ' . $this->ends_at->format('H:i') . ' WITA';
        }

        return $startText . ' WITA - ' . $this->ends_at->translatedFormat('d F Y H:i') . ' WITA';
    }

    public function getDateText(): string
    {
        if (!$this->starts_at) return 'Menyusul';
        
        $startText = $this->starts_at->translatedFormat('d F Y');
        
        if (!$this->ends_at || $this->starts_at->isSameDay($this->ends_at)) {
            return $startText;
        }

        return $startText . ' - ' . $this->ends_at->translatedFormat('d F Y');
    }

    public function getTimeText(): string
    {
        if (!$this->starts_at) return 'Menyusul';
        
        $startText = $this->starts_at->format('H:i') . ' WITA';
        
        $noEndTime = !$this->ends_at || $this->ends_at->format('H:i:s') === '23:59:59';
        
        if ($noEndTime) {
            return $startText . ' - Selesai';
        }

        return $startText . ' - ' . $this->ends_at->format('H:i') . ' WITA';
    }

    public function getAdminScheduleText(): string
    {
        if (!$this->starts_at) return 'Menyusul';
        
        $startText = $this->starts_at->format('d/m/Y H:i');
        
        $noEndTime = !$this->ends_at || $this->ends_at->format('H:i:s') === '23:59:59';
        
        if ($noEndTime) {
            if ($this->ends_at && !$this->starts_at->isSameDay($this->ends_at)) {
                return $startText . ' WITA - ' . $this->ends_at->format('d/m/Y') . ' Selesai';
            }
            return $startText . ' WITA - Selesai';
        }

        if ($this->starts_at->isSameDay($this->ends_at)) {
            return $startText . ' WITA - ' . $this->ends_at->format('H:i') . ' WITA';
        }

        return $startText . ' WITA - ' . $this->ends_at->format('d/m/Y H:i') . ' WITA';
    }

    public function getAdminDateText(): string
    {
        if (!$this->starts_at) return 'Menyusul';
        
        $startText = $this->starts_at->format('d/m/Y');
        
        if (!$this->ends_at || $this->starts_at->isSameDay($this->ends_at)) {
            return $startText;
        }

        return $startText . ' - ' . $this->ends_at->format('d/m/Y');
    }

    public function getAdminTimeText(): string
    {
        if (!$this->starts_at) return 'Menyusul';
        
        $startText = $this->starts_at->format('H.i') . ' WITA';
        
        $noEndTime = !$this->ends_at || $this->ends_at->format('H:i:s') === '23:59:59';
        
        if ($noEndTime) {
            return $startText . ' - Selesai';
        }

        return $startText . ' - ' . $this->ends_at->format('H.i') . ' WITA';
    }
}
