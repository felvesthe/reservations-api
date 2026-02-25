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
use App\Pipelines\Filters\Reservables\NameFilter;
use App\Pipelines\Filters\Reservables\TypeFilter;
use App\Pipelines\SortBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Pipeline;
use Symfony\Component\HttpFoundation\Response;

final class ReservableController extends Controller
{
    public function index(): Response
    {
        $this->authorize('view-any', Reservable::class);

        $pipes = [
            new NameFilter(),
            new TypeFilter(),
            new SortBy(),
        ];

        /** @var Builder<Reservable> $query */
        $query = Pipeline::send(Reservable::query())
            ->through($pipes)
            ->thenReturn();

        $reservables = $query->simplePaginate(
            perPage: config()->integer('pagination.per_page'),
        );

        return ReservableResource::collection(
            resource: $reservables,
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
