<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Text Analysis API Routes
Route::post('/v1/analyze', [ApiController::class, 'analyzeText']);
Route::get('/v1/status', [ApiController::class, 'status']);

// Project Request Details API Routes
Route::get('/projects/{project}/requests/{request}', [ApiController::class, 'getRequestDetails']);
