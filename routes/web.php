<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Visitor\HomeController;
use App\Http\Controllers\Visitor\GoogleDriveMediaController;
use App\Http\Controllers\Visitor\NewsController;
use App\Http\Controllers\Visitor\RegistrationController;
use App\Http\Controllers\Visitor\ActivityRegistrationController as VisitorActivityRegistrationController;
use App\Http\Controllers\Admin\LiveStreamingController as AdminLiveStreamingController;
use App\Http\Controllers\Admin\ActivityRegistrationController as AdminActivityRegistrationController;
use App\Http\Controllers\Admin\PerformanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('visitor.home');
Route::get('/berita-pengumuman', [NewsController::class, 'index'])->name('visitor.news');
Route::get('/jadwal-lomba', [HomeController::class, 'competitions'])->name('visitor.competitions');
Route::get('/peta-lokasi', [HomeController::class, 'locations'])->name('visitor.locations');
Route::get('/video-kemerdekaan', [HomeController::class, 'videos'])->name('visitor.videos');
Route::get('/live-streaming', [HomeController::class, 'liveStreamings'])->name('visitor.live_streamings');
Route::get('/live-performances', [HomeController::class, 'livePerformances'])->name('visitor.live_performances');
Route::get('/media/google-drive/{fileId}', GoogleDriveMediaController::class)->name('visitor.media.google-drive');
Route::get('/pendaftaran', [RegistrationController::class, 'create'])->name('visitor.registration.create');
Route::get('/pendaftaran/{competition:slug}', [RegistrationController::class, 'create'])->name('visitor.registration.competition');
Route::post('/pendaftaran', [RegistrationController::class, 'store'])->middleware('throttle:10,1')->name('visitor.registration.store');
Route::get('/pendaftaran/berhasil', [RegistrationController::class, 'success'])->name('visitor.registration.success');

Route::get('/kegiatan/{location}/daftar', [VisitorActivityRegistrationController::class, 'create'])->name('visitor.activity_registration.create');
Route::post('/kegiatan/{location}/daftar', [VisitorActivityRegistrationController::class, 'store'])->middleware('throttle:10,1')->name('visitor.activity_registration.store');
Route::get('/kegiatan/daftar/berhasil', [VisitorActivityRegistrationController::class, 'success'])->name('visitor.activity_registration.success');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\IsSuperAdmin;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsOperatorOrSuperAdmin;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function (): void {
    // Shared Routes (Super Admin & Operator)
    Route::get('/', DashboardController::class)->name('dashboard');
    
    // Registrations & Performances (Super Admin & Operator only, no Admin)
    Route::middleware([IsOperatorOrSuperAdmin::class])->group(function (): void {
        Route::resource('registrations', AdminRegistrationController::class)->except(['create', 'store', 'show']);
        Route::patch('registrations/{registration}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.status');

        Route::post('registrations/{registration}/performances', [PerformanceController::class, 'store'])->name('registrations.performances.store');
        Route::put('performances/{performance}', [PerformanceController::class, 'update'])->name('performances.update');
        Route::patch('performances/{performance}', [PerformanceController::class, 'update'])->name('performances.status');
        Route::delete('performances/{performance}', [PerformanceController::class, 'destroy'])->name('performances.destroy');
    });
    
    // Admin & Super Admin Routes
    Route::middleware([IsAdmin::class])->group(function (): void {
        Route::resource('banners', BannerController::class);
        
        Route::resource('locations', LocationController::class);
        Route::get('locations/{location}/registrations', [AdminActivityRegistrationController::class, 'index'])->name('locations.registrations.index');
        Route::patch('activity_registrations/{registration}/status', [AdminActivityRegistrationController::class, 'updateStatus'])->name('activity_registrations.status');
        Route::delete('activity_registrations/{registration}', [AdminActivityRegistrationController::class, 'destroy'])->name('activity_registrations.destroy');
        
        Route::resource('videos', VideoController::class);
        Route::resource('live_streamings', AdminLiveStreamingController::class);
    });

    // Super Admin Only Routes
    Route::middleware([IsSuperAdmin::class])->group(function (): void {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('competitions', CompetitionController::class);
        Route::patch('competitions/{competition}/status', [CompetitionController::class, 'updateStatus'])->name('competitions.status');
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

Route::get('/storage-link', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Storage link created successfully.';
});
