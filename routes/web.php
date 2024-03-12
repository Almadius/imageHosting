<?php

use App\Http\Controllers\Web\ImageWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImageWebController::class, 'index']);

Route::get('/images', [ImageWebController::class, 'index']);
Route::get('/images/download/{id}', [ImageWebController::class, 'download']);
Route::post('/images/download/multiple', [ImageWebController::class, 'downloadMultiple']);

Route::post('/images/upload', [ImageWebController::class, 'upload'])->name('images.upload');
