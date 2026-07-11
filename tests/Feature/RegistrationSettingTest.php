<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Tests\TestCase;

class RegistrationSettingTest extends TestCase
{
    public function test_closed_registration_shows_message_but_page_is_accessible(): void
    {
        $setting = SiteSetting::current();
        $original = $this->originalSetting($setting);

        try {
            $setting->update([
                'registration_enabled' => false,
                'registration_status' => SiteSetting::REGISTRATION_CLOSED,
                'registration_closed_message' => 'Pendaftaran sedang ditutup.',
            ]);

            $this->get(route('visitor.home'))
                ->assertOk()
                ->assertSee('Pendaftaran sedang ditutup.');

            $this->get(route('visitor.registration.create'))
                ->assertOk()
                ->assertSee('Pendaftaran Ditutup')
                ->assertSee('Pendaftaran sedang ditutup.')
                ->assertDontSee('Kirim Pendaftaran');
        } finally {
            SiteSetting::current()->update($original);
        }
    }

    public function test_hidden_registration_is_removed_from_menu_and_returns_not_found(): void
    {
        $setting = SiteSetting::current();
        $original = $this->originalSetting($setting);

        try {
            $setting->update([
                'registration_enabled' => false,
                'registration_status' => SiteSetting::REGISTRATION_HIDDEN,
                'registration_closed_message' => 'Pendaftaran sedang ditutup.',
            ]);

            $this->get(route('visitor.home'))
                ->assertOk()
                ->assertDontSee('Pendaftaran Lomba');

            $this->get(route('visitor.registration.create'))->assertNotFound();
        } finally {
            SiteSetting::current()->update($original);
        }
    }

    private function originalSetting(SiteSetting $setting): array
    {
        return [
            'registration_enabled' => $setting->registration_enabled,
            'registration_status' => $setting->registrationStatus(),
            'registration_closed_message' => $setting->registration_closed_message,
        ];
    }
}
