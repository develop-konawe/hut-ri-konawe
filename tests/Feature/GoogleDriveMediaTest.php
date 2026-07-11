<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleDriveMediaTest extends TestCase
{
    public function test_google_drive_media_is_proxied_as_inline_video(): void
    {
        Http::fake([
            'drive.usercontent.google.com/download*' => Http::response('video-bytes', 200, [
                'Content-Type' => 'video/mp4',
            ]),
        ]);

        $response = $this->get('/media/google-drive/1z0DToDM1e_fVSIay1wAW0G1bIejyfbKD');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'video/mp4');
        $response->assertSee('video-bytes');
    }

    public function test_google_drive_html_response_is_rejected(): void
    {
        Http::fake([
            'drive.usercontent.google.com/download*' => Http::response('<html>blocked</html>', 200, [
                'Content-Type' => 'text/html; charset=utf-8',
            ]),
        ]);

        $this->get('/media/google-drive/1z0DToDM1e_fVSIay1wAW0G1bIejyfbKD')->assertNotFound();
    }
}
