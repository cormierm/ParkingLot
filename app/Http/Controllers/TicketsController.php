<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use App\Ticket;

class TicketsController extends Controller
{
    const MAX_SPACES = 5;

    public function create() {
        if ((self::MAX_SPACES - Ticket::all()->count()) <= 0){
            return [
                'message' => 'Sorry, Parking is full. Please wait till space becomes available.'
            ];
        }

        $ticket = $this->createNewTicket();

        session('ticketNumber', $ticket->id);
        session('pin', $ticket->pin);

        return [
            'ticket' => $ticket,
            'message' => 'Ticket successfully created.'
            ];
    }

    public function cancel(Request $request) {
        try {
            $ticket = Ticket::findOrFail($request->ticket_number);
        }
        catch (ModelNotFoundException $ex) {
            return "Invalid entry.";
        }

        if ($ticket->pin == strtoupper($request->pin)) {
            $ticket->delete();
            return "Ticket successfully cancelled.";
        }
        else {
            return "Invalid entry.";
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
