<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\DestroyUserAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends Controller
{
    public function index(): Response
    {
        $this->authorize('view-any', User::class);

        return UserResource::collection(
            User::paginate(config()->integer('pagination.per_page')),
        )->response()->setStatusCode(Response::HTTP_OK);
    }

    public function show(User $user): Response
    {
        $this->authorize('view', $user);

        return new JsonResponse(
            data: UserResource::make($user),
            status: Response::HTTP_OK,
        );
    }

    public function destroy(User $user, DestroyUserAction $destroyUserAction): Response
    {
        $this->authorize('delete', $user);

        $destroyUserAction->execute($user);

        return response()->noContent();
    }
}
