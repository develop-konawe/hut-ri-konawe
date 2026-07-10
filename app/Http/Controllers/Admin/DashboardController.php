<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'competitionCount' => Competition::query()->count(),
            'registrationCount' => Registration::query()->count(),
            'locationCount' => ActivityLocation::query()->count(),
            'latestRegistrations' => Registration::query()->with('competition')->latest('submitted_at')->limit(6)->get(),
        ]);
    }
}
