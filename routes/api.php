<?php

use App\Http\Controllers\Api\ImageApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/images/{id}', [ImageApiController::class, 'show']);
