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
            'registration_deadline' => 'datetime',
            'is_open' => 'boolean',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
