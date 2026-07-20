<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'stage',
        'is_published',
        'performance_status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function performances(): HasMany
    {
        return $this->hasMany(Performance::class)->orderBy('scheduled_at')->orderBy('order_number');
    }

    public static function statuses(): array
    {
        return [
            'submitted' => 'Baru / Menunggu',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];
    }

    public static function stages(): array
    {
        return [
            'Penyisihan',
            'Semi Final',
            'Final',
        ];
    }

    public static function performanceStatuses(): array
    {
        return [
            'Menunggu Panggilan',
            'Sedang Tampil',
            'Selesai',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? ucfirst($this->status);
    }
}
