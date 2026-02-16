<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\UserController;

Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/{user}', [UserController::class, 'show'])->name('show');
Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
