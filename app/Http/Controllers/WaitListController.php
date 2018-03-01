<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Waitlist;

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
}
