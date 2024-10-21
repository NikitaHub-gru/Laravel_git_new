<?php

use Illuminate\Support\Facades\Route;
use App\Controllers\ReportController;

Route::get('/', [ReportController::class, 'index']);
Route::post('/refresh', [ReportController::class, 'refresh']);
