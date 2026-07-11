<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'setting' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'registration_status' => ['required', 'in:open,closed,hidden'],
            'registration_closed_message' => ['nullable', 'string', 'max:500'],
            'header_title' => ['nullable', 'string', 'max:255'],
            'footer_title' => ['nullable', 'string', 'max:255'],
            'header_konawe_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'header_hutri_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'hero_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'hero_background' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        $setting = SiteSetting::current();

        $payload = [
            'registration_enabled' => $validated['registration_status'] === SiteSetting::REGISTRATION_OPEN,
            'registration_status' => $validated['registration_status'],
            'registration_closed_message' => $validated['registration_closed_message'] ?: SiteSetting::DEFAULT_REGISTRATION_CLOSED_MESSAGE,
            'header_title' => $validated['header_title'] ?: null,
            'footer_title' => $validated['footer_title'] ?: null,
        ];

        foreach ([
            'header_konawe_logo' => 'header_konawe_logo_path',
            'header_hutri_logo' => 'header_hutri_logo_path',
            'hero_logo' => 'hero_logo_path',
            'hero_background' => 'hero_background_path',
        ] as $input => $column) {
            if ($request->hasFile($input)) {
                $payload[$column] = $this->storeSettingFile($request->file($input));
            }
        }

        $setting->update($payload);

        return to_route('admin.settings.edit')->with('status', 'Pengaturan portal berhasil diperbarui.');
    }

    private function storeSettingFile(UploadedFile $file): string
    {
        $directory = public_path('uploads/settings');

        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/settings/'.$filename;
    }
}
