<?php

namespace App\Services;

use App\Models\Competition;
use App\Models\Registration;
use App\Models\SiteSetting;
use Illuminate\Support\Carbon;
use RuntimeException;

final class RegistrationService
{
    public function register(Competition $competition, array $data): Registration
    {
        if (! SiteSetting::registrationEnabled()) {
            throw new RuntimeException(SiteSetting::current()->closedMessage());
        }

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
