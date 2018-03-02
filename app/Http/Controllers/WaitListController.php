<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Waitlist;
use Illuminate\Support\Facades\Mail;

class WaitListController extends Controller
{
    const MAX_WAIT_LIST = 10;

    public function store(Request $request)
    {
        if (TicketsController::availableSpaces() > 0) {
            return ['error' => 'Cannot be added to Wait List. There are parking spaces available.'];
        }

        $waitList = Waitlist::all();

        if($waitList->count() >= self::MAX_WAIT_LIST) {
            return ['error' => 'Sorry, Wait List is full.'];
        }

        $this->validate($request, [
            'email' => 'required|email|unique:waitlists',
            'name'  => 'max:100'
        ]);

        Waitlist::create($request->all());
        return ['success' => 'Successfully added to Wait List'];
    }

    public static function processWaitList() {
        $nextWaitListUser = Waitlist::all()->first();

        if (!is_null($nextWaitListUser)) {
            $nextWaitListUser->delete();

            $ticket = TicketsController::createNewTicket();
            $ticket->is_entered = false;
            $ticket->save();

            $data = [
                'ticket_number' => $ticket->id,
                'pin' => $ticket->pin
            ];

            Mail::send('emails.waitlist', $data, function ($message) use ($nextWaitListUser) {
                $message->to($nextWaitListUser->email, $nextWaitListUser->name)->subject('Vehikl Parking Spot Available');
            });
        }
    }
}
