<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Ticket;

class ParkingController extends Controller
{
    public function processExit(Request $request)
    {
        $this->validate($request, [
            'ticket_number' =>  'required|integer',
            'pin'           =>  'required|size:4'
        ]);

        $pin = strtoupper($request->pin);

        try {
            $ticket = Ticket::findOrFail($request->ticket_number);
        }
        catch (ModelNotFoundException $ex) {
            return ['error' => 'Ticket number or PIN was incorrect.'];
        }

        if ($ticket->pin != $pin) {
            return ['error' => 'Ticket number or PIN was incorrect.'];
        }
        else if (!$ticket->is_paid)
        {
            return ['error' => 'Ticket is not paid.'];
        }
        else if ($ticket->is_paid && $ticket->pin == $pin)
        {
            $ticket->delete();
            WaitListController::processWaitList();
            return ['success' => 'Thank you for your business!'];
        }
    }

    public function waitListBypass(Request $request)
    {
        $this->validate($request, [
            'ticket_number' =>  'required|integer',
            'pin'           =>  'required|size:4'
        ]);

        $pin = strtoupper($request->pin);

        try {
            $ticket = Ticket::findOrFail($request->ticket_number);
        }
        catch (ModelNotFoundException $ex) {
            return ['error' => 'Ticket number or PIN was incorrect.'];
        }

        if ($ticket->pin != $pin) {
            return ['error' => 'Ticket number or PIN was incorrect.'];
        }
        else if (!$ticket->is_entered) {
            $ticket->is_entered = true;
            $ticket->save();
            return ['success' => 'Thank you, Please enter.'];
        }

        return ['error' => 'Ticket is invalid or expired.'];
    }
}
