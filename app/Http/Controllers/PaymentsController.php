<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        if($ticket != null && $ticket->pin == $pin) {
            if($ticket->is_paid) {
                return ['error' => 'Ticket already paid.'];
            }
            $ticket->time_out = Carbon::now();
            $ticket->save();

            $totalTime = Carbon::parse($ticket->created_at)->diffInMinutes(Carbon::parse($ticket->time_out));
            $amountDue = number_format(self::processRate($totalTime), 2);

            return [
                'ticket' => $ticket,
                'totalTime' => $totalTime,
                'amountDue' => $amountDue,
                'timeIn' => $ticket->created_at->setTimezone('America/Toronto')->toDayDateTimeString(),
                'timeOut' => $ticket->time_out->setTimezone('America/Toronto')->toDayDateTimeString()
            ];
        }

        return ['error' => 'Ticket number or PIN was incorrect.'];
    }

    public function processPayment(Request $request) {
        $ticket = Ticket::find($request->ticket_number);
        $ticket->is_paid = true;
        $ticket->save();

        return ['success' => 'Successfully paid'];
    }

    public static function processRate($totalTime) {
        switch ($totalTime) {
            case $totalTime === '0':
            case $totalTime <= 60:
                return self::BASE_RATE;
                break;
            case $totalTime <= 60 * 3:
                return self::BASE_RATE * 1.5;
                break;
            case  $totalTime <= 60 * 6:
                return self::BASE_RATE * pow(1.5, 2);
                break;
            default:
                return self::BASE_RATE * pow(1.5, 3);
                break;
        }
    }
}