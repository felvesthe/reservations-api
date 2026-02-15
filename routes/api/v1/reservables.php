<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\ReservableController;

Route::get('/', [ReservableController::class, 'index'])->name('index');
Route::post('/', [ReservableController::class, 'store'])->name('store');
Route::get('/{reservable}', [ReservableController::class, 'show'])->name('show');
Route::patch('/{reservable}', [ReservableController::class, 'update'])->name('update');
Route::delete('/{reservable}', [ReservableController::class, 'destroy'])->name('destroy');
