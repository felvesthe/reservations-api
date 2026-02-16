<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\CreateReservableAction;
use App\Actions\Api\V1\DestroyReservableAction;
use App\Actions\Api\V1\UpdateReservableAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Reservables\StoreReservableRequest;
use App\Http\Requests\V1\Reservables\UpdateReservableRequest;
use App\Http\Resources\V1\ReservableResource;
use App\Models\Reservable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ReservableController extends Controller
{
    public function index(): Response
    {
        $this->authorize('view-any', Reservable::class);

        return ReservableResource::collection(
            resource: Reservable::simplePaginate(
                perPage: config()->integer('pagination.per_page'),
            ),
        )->response()->setStatusCode(
            code: Response::HTTP_OK,
        );
    }

    public function store(StoreReservableRequest $request, CreateReservableAction $createReservableAction): Response
    {
        $createReservableAction->execute($request);

        return response()->noContent();
    }

    public function show(Reservable $reservable): Response
    {
        $this->authorize('view', $reservable);

        return new JsonResponse(
            data: ReservableResource::make($reservable),
            status: Response::HTTP_OK,
        );
    }

    public function update(UpdateReservableRequest $request, Reservable $reservable, UpdateReservableAction $updateReservableAction): Response
    {
        $updateReservableAction->execute($request, $reservable);

        return response()->noContent();
    }

    public function destroy(Reservable $reservable, DestroyReservableAction $destroyReservableAction): Response
    {
        $this->authorize('delete', $reservable);

        $destroyReservableAction->execute($reservable);

        return response()->noContent();
    }
}
