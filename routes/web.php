<?php

use App\Http\Controllers\ImageRemoveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/remove-background', [ImageRemoveController::class, 'showForm'])->name('remove.bg.form');
Route::post('/remove-background', [ImageRemoveController::class, 'remove'])->name('remove.bg');
