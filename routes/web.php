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
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('visitor.home');
Route::get('/berita-pengumuman', [NewsController::class, 'index'])->name('visitor.news');
Route::get('/jadwal-lomba', [HomeController::class, 'competitions'])->name('visitor.competitions');
Route::get('/peta-lokasi', [HomeController::class, 'locations'])->name('visitor.locations');
Route::get('/video-kemerdekaan', [HomeController::class, 'videos'])->name('visitor.videos');
Route::get('/media/google-drive/{fileId}', GoogleDriveMediaController::class)->name('visitor.media.google-drive');
Route::get('/pendaftaran', [RegistrationController::class, 'create'])->name('visitor.registration.create');
Route::get('/pendaftaran/{competition:slug}', [RegistrationController::class, 'create'])->name('visitor.registration.competition');
Route::post('/pendaftaran', [RegistrationController::class, 'store'])->name('visitor.registration.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('banners', BannerController::class);
    Route::resource('competitions', CompetitionController::class);
    Route::get('registrations', AdminRegistrationController::class)->name('registrations.index');
    Route::patch('registrations/{registration}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.status');
    Route::resource('locations', LocationController::class);
    Route::resource('videos', VideoController::class);
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
