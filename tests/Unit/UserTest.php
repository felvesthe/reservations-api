<?php

declare(strict_types=1);

use App\Models\User;

test('user has properly set full_name attribute', function (): void {
    $user = User::factory()->make([
        'first_name' => 'John',
        'last_name' => 'Smith',
    ]);

    expect($user->full_name)
        ->toBe('John Smith');
});
