<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\BookingController;

Route::get('/', [BookingController::class, 'index'])->name('index');
Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
Route::post('/', [BookingController::class, 'store'])->name('store');
Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
