<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1:')->group(function (): void {
    Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum');

    Route::prefix('reservables')
        ->as('reservables:')
        ->group(
            base_path('routes/api/v1/reservables.php'),
        );
});

if (App::environment('local')) {
    Route::post('/token', LoginController::class)->name('token');
}
