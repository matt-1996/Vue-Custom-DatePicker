<?php

namespace App\Http\Controllers\Api\V1\Room;

use App\Enums\RoomPriceEnum;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoomController extends Controller
{

    public function index(){
        $userRooms = Auth::user()->with('rooms.user')->first();

        return Inertia::render('Dashboard', [
            'rooms' => $userRooms->rooms
        ]);
    }

    public function show($id){
        $room = Room::with(['events'])->find($id);

        // dd($room);

        return Inertia::render('Room', [
            'room' => $room,
            'defaultPrice' => RoomPriceEnum::PRICE->value
        ]);
    }

    public function update(int $id, Request $request){
        $request->validate([

        ]);

        $room = Room::findOrFail($id);

        $room->update([
            'events' => $request->event
        ]);
    }
}