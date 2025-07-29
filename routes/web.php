<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminHomepageController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TransactionController;

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

// Feedback route
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    
    // Admin user management
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/admin/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users/{id}/block', [AdminController::class, 'toggleBlock'])->name('admin.users.block');
    
    // Admin user details
    Route::get('/admin/users/{id}/projects', [AdminController::class, 'userProjects'])->name('admin.users.projects');
    Route::get('/admin/users/{id}/requests', [AdminController::class, 'userRequests'])->name('admin.users.requests');
    Route::get('/admin/users/{id}/stats', [AdminController::class, 'userStats'])->name('admin.users.stats');
    

    
    // Admin profile
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/plans', PlanController::class, ['as' => 'admin']);
    Route::resource('admin/transactions', TransactionController::class, ['as' => 'admin'])->only(['index', 'show']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::post('/plans/{plan}/purchase', [PlanController::class, 'purchase'])->name('plans.purchase');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/send-request', [ProfileController::class, 'sendRequest'])->name('profile.send_request');
    Route::get('/profile/info', [ProfileController::class, 'info'])->name('profile.info');
    Route::get('/profile/balance', [ProfileController::class, 'balance'])->name('profile.balance');
    Route::get('/profile/api-test', [ProfileController::class, 'apiTest'])->name('profile.api-test');
    Route::post('/profile/api-test', [ProfileController::class, 'testApi'])->name('profile.test-api');
    
    // Projects routes
    Route::resource('profile/projects', ProjectController::class, ['as' => 'profile']);
    Route::get('/profile/projects/{project}/stats', [ProjectController::class, 'stats'])->name('profile.projects.stats');
    Route::get('/profile/projects/{project}/requests', [ProjectController::class, 'requests'])->name('profile.projects.requests');
    Route::post('/profile/projects/{project}/regenerate-token', [ProjectController::class, 'regenerateToken'])->name('profile.projects.regenerate-token');
    Route::get('/profile/projects/{project}/settings', [ProjectController::class, 'settings'])->name('profile.projects.settings');
    Route::post('/profile/projects/{project}/update-settings', [ProjectController::class, 'updateSettings'])->name('profile.projects.update-settings');
    
    // Plans and transactions routes
    Route::get('/profile/plans', [\App\Http\Controllers\PlanController::class, 'userIndex'])->name('plans.index');
    Route::get('/profile/transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/feedbacks', [AdminFeedbackController::class, 'index'])->name('admin.feedbacks');
    Route::get('/admin/feedbacks/{id}', [AdminFeedbackController::class, 'show'])->name('admin.feedbacks.show');
});

// Admin plans CRUD
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('plans', PlanController::class);
});
