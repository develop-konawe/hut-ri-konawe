<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class GoogleDriveMediaController extends Controller
{
    public function __invoke(Request $request, string $fileId): Response
    {
        abort_unless((bool) preg_match('/^[A-Za-z0-9_-]+$/', $fileId), 404);

        $headers = [
            'User-Agent' => 'Mozilla/5.0',
        ];

        if ($request->header('Range')) {
            $headers['Range'] = $request->header('Range');
        }

        $googleResponse = Http::withHeaders($headers)
            ->timeout(60)
            ->withOptions(['allow_redirects' => true])
            ->get('https://drive.usercontent.google.com/download', [
                'id' => $fileId,
                'export' => 'download',
            ]);

        abort_unless($googleResponse->successful(), 404);

        $contentType = $googleResponse->header('Content-Type', 'video/mp4');

        abort_if(str_contains(strtolower($contentType), 'text/html'), 404);

        $response = response($googleResponse->body(), $googleResponse->status())
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', 'inline')
            ->header('Cache-Control', 'public, max-age=3600')
            ->header('Accept-Ranges', 'bytes');

        foreach (['Content-Length', 'Content-Range'] as $header) {
            if ($googleResponse->header($header)) {
                $response->header($header, $googleResponse->header($header));
            }
        }

        return $response;
    }
}
