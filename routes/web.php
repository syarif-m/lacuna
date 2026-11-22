<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\CaseDetailController;
use App\Http\Controllers\Member\CaseSubmissionController;

// Public
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/discover', [DiscoverController::class, 'index'])
    ->name('discover');

Route::get('/about', function () {
    return view('about');
        })->name('about');

Route::get('/cases/{slug}', [CaseDetailController::class, 'show'])
    ->name('cases.show');

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});

// Authenticated users
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Member
    Route::middleware('role:MEMBER')
        ->prefix('member')
        ->name('member.')
        ->group(function () {
            Route::get('/dashboard', [MemberDashboardController::class, 'index'])
                ->name('dashboard');
            Route::get('/cases/create', [CaseSubmissionController::class, 'create'])
                ->name('cases.create');
            Route::post('/cases', [CaseSubmissionController::class, 'store'])
                ->name('cases.store');

            
        });
    // Admin
    Route::middleware('role:ADMIN')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');
        });

});
