<?php

namespace App\Application\Registration;

use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Support\Carbon;
use RuntimeException;

final class RegisterParticipant
{
    public function handle(Competition $competition, array $data): Registration
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
