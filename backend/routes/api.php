<?php

use App\Http\Controllers\HealthCheckController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the API middleware group automatically.
| All routes here receive the /api prefix.
|
*/

// Health check endpoint — public, no auth required
Route::get('/health', HealthCheckController::class);
