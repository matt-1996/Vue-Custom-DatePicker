<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use File;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = json_decode(File::get(__DIR__ . '/rooms.json'));

        foreach ($rooms as $room) {
            $roomModel = Room::create([
                'title' => $room->title,
                'description' => $room->description,
                'user_id' => $room->user_id,
            ]);

            foreach ($room->events as $event) {
                Event::create([
                   'room_id' => $roomModel->id,
                   'check_in' => $event->check_in,
                   'check_out' => $event->check_out,
                   'has_discount' => $event->has_discount,
                   'price' => $event->price,
                   'is_open' => $event->is_open,
                   'is_reserved' => $event->is_reserved,
                   'date' => $event->date,
                ]);
            }
        }
    }
}
