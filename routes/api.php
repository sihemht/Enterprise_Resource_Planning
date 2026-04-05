<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
