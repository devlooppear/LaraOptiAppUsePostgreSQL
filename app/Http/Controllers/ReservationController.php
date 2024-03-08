<?php

namespace App\Http\Controllers;

use App\Events\ReservationEvent;
use App\Models\Reservation;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Reservation::with(['user', 'book'])->orderBy('id', 'asc');

            if ($request->has('page')) {
                $reservations = $query->paginate(18);
            } else {
                $reservations = $query->get();
            }

            return response()->json($reservations);
        } catch (Exception $e) {
            Log::error('Error fetching reservations: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while fetching reservations: ' . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created reservation in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'book_id' => 'required|integer|exists:books,id',
                'reservation_date' => 'date',
                'pickup_deadline' => 'date',
                'is_active' => 'boolean',
            ]);

            $data = $request->all();
            $data['user_id'] = intval($data['user_id']);
            $data['book_id'] = intval($data['book_id']);
            $data['is_active'] = intval($data['is_active']);

            $reservation = Reservation::create($data);

            try {
                event(new ReservationEvent($reservation->toArray(), 'created'));
            } catch (Exception $eventException) {
                Log::error('Error triggering reservation event: ' . $eventException->getMessage());
            }

            return response()->json(['data' => $reservation], 201);
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->getMessage()], 422);
        } catch (Exception $exception) {
            Log::error('Error storing reservation: ' . $exception->getMessage());

            return response()->json(['error' => 'An error occurred while storing the reservation.'], 500);
        }
    }

    /**
     * Display the specified reservation.
     *
     * @return Response
     */
    public function show(Reservation $reservation)
    {
        try {
            return response()->json($reservation);
        } catch (Exception $e) {
            Log::error('Error fetching reservation details: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while fetching reservation details: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified reservation in storage.
     *
     * @return Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        try {
            $request->validate([
                'user_id' => 'nullable|exists:users,id|integer',
                'book_id' => 'nullable|exists:books,id|integer',
                'reservation_date' => 'nullable|date_format:Y-m-d H:i:s',
                'pickup_deadline' => 'nullable|date_format:Y-m-d H:i:s',
                'is_active' => 'nullable|numeric|in:0,1',
            ]);

            $user_id = $request->input('user_id');
            $book_id = $request->input('book_id');
            $is_active = $request->input('is_active');

            if (! is_null($user_id)) {
                $request->merge(['user_id' => intval($user_id)]);
            }

            if (! is_null($book_id)) {
                $request->merge(['book_id' => intval($book_id)]);
            }

            if (! is_null($is_active)) {
                $request->merge(['is_active' => intval($is_active)]);
            }

            $reservation->fill($request->all())->save();

            try {
                event(new ReservationEvent($reservation->toArray(), 'updated'));
            } catch (Exception $eventException) {
                Log::error('Error triggering reservation event: ' . $eventException->getMessage());
            }

            return response()->json($reservation, 200);
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json(['error' => 'Reservation not found.'], 404);
        } catch (Exception $exception) {
            Log::error('Error updating reservation: ' . $exception->getMessage());

            return response()->json(['error' => 'An error occurred while updating the reservation.'], 500);
        }
    }

    /**
     * Remove the specified reservation from storage.
     *
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();

            try {
                event(new ReservationEvent($reservation->toArray(), 'deleted'));
            } catch (Exception $eventException) {
                Log::error('Error triggering reservation event: ' . $eventException->getMessage());
            }

            return response()->json(['message' => 'Reservation successfully deleted'], 200);
        } catch (Exception $exception) {
            Log::error('Error deleting reservation: ' . $exception->getMessage());

            return response()->json(['error' => 'Failed to delete the reservation. Please try again.'], 500);
        }
    }
}
