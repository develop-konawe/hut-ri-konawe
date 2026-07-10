<?php

namespace App\Services;

use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Support\Carbon;
use RuntimeException;

final class RegistrationService
{
    public function register(Competition $competition, array $data): Registration
    {
        if (! $competition->is_open) {
            throw new RuntimeException('Pendaftaran lomba sudah ditutup.');
        }

        return $competition->registrations()->create([
            ...$data,
            'status' => 'submitted',
            'submitted_at' => Carbon::now(),
        ]);
    }
}
