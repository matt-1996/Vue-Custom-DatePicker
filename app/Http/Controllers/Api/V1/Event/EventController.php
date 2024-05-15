<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Enums\RoomPriceEnum;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Room;

class EventController extends Controller
{
    public function update(Request $request)
    {

        $room = Room::find($request->roomId);

        foreach ($request->days as $key => $day) {
            $room->events()->updateOrCreate([
                'date' => $request->days[$key]
            ],[
                'date' => $request->days[$key],
                'is_open' => $request->isOpen,
                'is_reserved' => 0,
                'price' => RoomPriceEnum::PRICE->value
            ]);
        }


        return $this->setData($room->events()->get())->response();
    }

    public function reserve(int $id ,Request $request)
    {
        $room = Room::find($id);

        foreach($request->days as $key => $day){
            $event = Event::where('room_id' , $id)->where('date' , $request->days[$key])->first();
            if($event){
                $event->check_in = $request->days[0];
                $event->check_out = $request->days[count($request->days) -1];
                $event->is_reserved = 1;
                $event->is_open = 0;
                $event->save();
            }else{
                if($key == 0){
                    Event::create([
                        'room_id' => $id,
                        'check_in' => $request->days[0],
                        'check_out' => $request->days[count($request->days) -1],
                        'date' => $request->days[$key],
                        'is_reserved' => 1,
                        'price' => RoomPriceEnum::PRICE->value,
                        'is_open' => 0
                    ]);
                }
            Event::create([
                'room_id' => $id,
                'date' => $request->days[$key],
                'is_reserved' => 1,
                'price' => RoomPriceEnum::PRICE->value,
                'is_open' => 0
            ]);
            }

        }

    return $this->setData($room->events()->get())->response();

    }

    public function updatePrice(Request $request)
    {

        if($request->id !== 0){
            Event::find($request->id)
                ->update([
                    'price' => $request->price,
                    'has_discount' => $request->has_discount ? 1 : 0
                ]);
        }else{
            Event::create([
                'room_id' => $request->room_id,
                'is_reserved' => 0,
                'is_open' => 1,
                'date' => $request->date,
                'price' => $request->price,
                'has_discount' => $request->has_discount ? 1 : 0
            ]);
        }

        $room = Room::find($request->room_id);

        return $this->setData($room->events()->get())->response();
    }


}
