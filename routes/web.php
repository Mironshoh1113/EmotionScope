<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminHomepageController;
use App\Http\Controllers\HomepageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomepageController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['uz', 'ru', 'en'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('lang.switch');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware([])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/send-request', [ProfileController::class, 'sendRequest'])->name('profile.send_request');
    Route::get('/profile/info', [ProfileController::class, 'info'])->name('profile.info');
    Route::get('/profile/balance', [ProfileController::class, 'balance'])->name('profile.balance');
    Route::get('/profile/stats', [ProfileController::class, 'stats'])->name('profile.stats');
    Route::get('/profile/requests', [ProfileController::class, 'requests'])->name('profile.requests');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users/{id}/block', [AdminController::class, 'toggleBlock'])->name('admin.users.block');
    Route::get('/admin/homepage', [AdminHomepageController::class, 'index'])->name('admin.homepage.index');
    Route::get('/admin/homepage/{id}/edit', [AdminHomepageController::class, 'edit'])->name('admin.homepage.edit');
    Route::post('/admin/homepage/{id}', [AdminHomepageController::class, 'update'])->name('admin.homepage.update');
});
