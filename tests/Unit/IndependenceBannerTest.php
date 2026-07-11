<?php

namespace Tests\Unit;

use App\Models\IndependenceBanner;
use PHPUnit\Framework\TestCase;

class IndependenceBannerTest extends TestCase
{
    public function test_google_drive_share_url_is_normalized_for_banner_media(): void
    {
        $this->assertSame(
            'https://drive.google.com/uc?export=download&id=1z0DToDM1e_fVSIay1wAW0G1bIejyfbKD',
            IndependenceBanner::normalizeMediaUrl('https://drive.google.com/file/d/1z0DToDM1e_fVSIay1wAW0G1bIejyfbKD/view?usp=sharing')
        );
    }

    public function test_google_drive_share_url_can_be_converted_to_preview_url(): void
    {
        $this->assertSame(
            'https://drive.google.com/file/d/1z0DToDM1e_fVSIay1wAW0G1bIejyfbKD/preview',
            IndependenceBanner::googleDrivePreviewUrl('https://drive.google.com/file/d/1z0DToDM1e_fVSIay1wAW0G1bIejyfbKD/view?usp=sharing')
        );
    }

    public function test_non_google_drive_url_is_not_changed(): void
    {
        $this->assertSame(
            'https://example.com/banner.mp4',
            IndependenceBanner::normalizeMediaUrl('https://example.com/banner.mp4')
        );
    }
}
