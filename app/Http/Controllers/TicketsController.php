<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Ticket;
use Illuminate\Http\Response;

class TicketsController extends Controller
{
    const MAX_SPACES = 5;

    public function create() {
        if ((self::MAX_SPACES - Ticket::all()->count()) <= 0) {
            return response()->json([
                'message' => 'Sorry, Parking is full. Please wait till space becomes available.'
            ], Response::HTTP_BAD_REQUEST );
        }

        $ticket = $this->createNewTicket();

        session('ticketNumber', $ticket->id);
        session('pin', $ticket->pin);

        return response()->json([
            'ticket' => $ticket,
            'message' => 'Ticket successfully created.'
            ], Response::HTTP_CREATED);
    }

    public function cancel(Request $request) {
        try {
            $ticket = Ticket::findOrFail($request->ticket_number);
        }
        catch (ModelNotFoundException $ex) {
            return "Invalid or expired entry.";
        }

        if ($ticket->pin == strtoupper($request->pin) && !$ticket->is_entered) {
            $ticket->delete();
            return "Ticket successfully cancelled.";
        }
        else {
            return "Invalid or expired entry.";
        }
    }

    public function status() {
        return [
            'available' => $this->availableSpaces()
        ];
    }

    public static function availableSpaces() {
        return self::MAX_SPACES - Ticket::all()->count();
    }

    public static function createNewTicket() {
        $ticket = new Ticket;
        $ticket->pin = strtoupper(str_random(4));
        $ticket->save();

        return $ticket;
    }
}
