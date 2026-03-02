<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RequestLoginCodeController;
use App\Http\Controllers\VerifyLoginCodeController;
use Illuminate\Support\Facades\Route;

Route::post('login-code/request', RequestLoginCodeController::class);
Route::post('login-code/verify', VerifyLoginCodeController::class);
Route::post('logout', LogoutController::class)->middleware('auth:sanctum');
