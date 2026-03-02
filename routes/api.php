<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('me', function (Request $request) {
    return new UserResource($request->user());
})->middleware('auth:sanctum');
