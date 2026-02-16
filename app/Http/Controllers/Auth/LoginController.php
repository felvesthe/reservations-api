<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

final class LoginController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(LoginRequest $request): Response
    {
        $credentials = [
            'email' => $request->string('email')->toString(),
            'password' => $request->string('password')->toString(),
        ];

        if (! Auth::attempt($credentials)) {
            throw new AuthenticationException(__('auth.failed'));
        }

        /** @var User $user */
        $user = Auth::user();

        $user->tokens()->where('name', 'api_token')->delete();

        $token = $user->createToken(
            name: 'api_token',
        );

        return new JsonResponse(
            data: [
                'token' => $token->plainTextToken,
            ],
            status: Response::HTTP_OK,
        );
    }
}
