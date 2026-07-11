<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'competition_id',
        'participant_name',
        'identity_number',
        'phone',
        'email',
        'institution',
        'address',
        'status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_SUBMITTED => 'Baru Masuk',
            self::STATUS_VERIFIED => 'Terverifikasi',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? ucfirst($this->status);
    }
}
