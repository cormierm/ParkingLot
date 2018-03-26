<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Ticket;
use Carbon\Carbon;

class PaymentsController extends Controller
{
    const BASE_RATE = 3.00;

    public function details(Request $request) {
        $this->validate($request, [
            'ticket_number'        =>  'required|integer',
            'pin' =>  'required|size:4'
        ]);

        $pin = strtoupper($request->pin);
        $ticket = Ticket::find($request->ticket_number);

        if($ticket != null && $ticket->pin != $pin) {
            return response()->json([
                'error' => 'Ticket number or PIN was incorrect.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if($ticket != null && $ticket->pin == $pin) {
            if($ticket->is_paid) {
                return ['error' => 'Ticket already paid.'];
            }
            $ticket->time_out = Carbon::now();
            $ticket->save();

            $totalTime = Carbon::parse($ticket->created_at)->diffInMinutes(Carbon::parse($ticket->time_out));
            $amountDue = number_format(self::processRate($totalTime), 2);

            return response()->json([
                'ticket' => $ticket,
                'totalTime' => $totalTime,
                'amountDue' => $amountDue,
                'timeIn' => $ticket->created_at->setTimezone('America/Toronto')->toDayDateTimeString(),
                'timeOut' => $ticket->time_out->setTimezone('America/Toronto')->toDayDateTimeString()
            ], Response::HTTP_ACCEPTED);
        }

        return ['error' => 'Ticket number or PIN was incorrect.'];
    }

    public function processPayment(Request $request) {
        $ticket = Ticket::find($request->ticket_number);
        $ticket->is_paid = true;
        $ticket->save();

        return response()->json([
                'success' => 'Successfully paid'
            ], Response::HTTP_OK);
    }

    public static function processRate($totalTime) {

        if ($totalTime <= 0) {
            return 0;
        }
        elseif ($totalTime <= 60) {
            return self::BASE_RATE;
        }
        elseif ($totalTime <= 60 * 3) {
            return self::BASE_RATE * 1.5;
        }
        elseif ($totalTime <= 60 * 6) {
            return self::BASE_RATE * pow(1.5, 2);
        }
        else {
            return self::BASE_RATE * pow(1.5, 3);
        }

    }
}
