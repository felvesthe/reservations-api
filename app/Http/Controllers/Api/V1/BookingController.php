<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\CreateBookingAction;
use App\Actions\Api\V1\DestroyBookingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Bookings\StoreBookingRequest;
use App\Http\Resources\V1\BookingResource;
use App\Http\Resources\V1\DetailedBookingResource;
use App\Models\Booking;
use App\Pipelines\Filters\Bookings\DateFilter;
use App\Pipelines\Filters\Bookings\ReservableFilter;
use App\Pipelines\Filters\Bookings\UserFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Pipeline;
use Symfony\Component\HttpFoundation\Response;

final class BookingController extends Controller
{
    public function index(): Response
    {
        $this->authorize('view-any', Booking::class);

        $filters = [
            new UserFilter(),
            new ReservableFilter(),
            new DateFilter(),
        ];

        /** @var Builder<Booking> $query */
        $query = Pipeline::send(Booking::query())
            ->through($filters)
            ->thenReturn();

        $bookings = $query
            ->simplePaginate(
                perPage: config()->integer('pagination.per_page'),
            );

        return BookingResource::collection(
            resource: $bookings,
        )->response()->setStatusCode(
            code: Response::HTTP_OK,
        );
    }

    public function store(StoreBookingRequest $request, CreateBookingAction $createBookingAction): Response
    {
        $createBookingAction->execute($request);

        return new JsonResponse(
            data: [
                'message' => __('responses.v1.bookings.store.success'),
            ],
            status: Response::HTTP_ACCEPTED,
        );
    }

    public function show(Booking $booking): Response
    {
        $this->authorize('view', $booking);

        return new JsonResponse(
            data: DetailedBookingResource::make($booking),
            status: Response::HTTP_OK,
        );
    }

    public function destroy(Booking $booking, DestroyBookingAction $destroyBookingAction): Response
    {
        $this->authorize('delete', $booking);

        $destroyBookingAction->execute($booking);

        return new JsonResponse(
            data: [
                'message' => __('responses.v1.bookings.destroy.success'),
            ],
            status: Response::HTTP_ACCEPTED,
        );
    }
}
