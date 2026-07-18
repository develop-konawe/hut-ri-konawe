<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLocation extends Model
{
    protected $fillable = [
        'name',
        'type',
        'address',
        'latitude',
        'longitude',
        'activity_at',
        'description',
        'is_registration_open',
        'registration_deadline',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'activity_at' => 'datetime',
            'is_registration_open' => 'boolean',
            'registration_deadline' => 'datetime',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(ActivityRegistration::class);
    }
}
