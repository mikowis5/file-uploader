<?php

use App\Http\Controllers\Api\FileController;
use Illuminate\Support\Facades\Route;

Route::resource('files', FileController::class)
    ->only(['index', 'store', 'destroy']);

Route::get('files/preview/{file}', [FileController::class, 'preview'])->name('file.preview');
Route::get('files/download/{file}', [FileController::class, 'download'])->name('file.download');
