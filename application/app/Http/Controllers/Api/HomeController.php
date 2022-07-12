<?php

namespace TheFarrelHotel\Http\Controllers\Api;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\ApiController;

use TheFarrelHotel\Http\Models\Facility;
use TheFarrelHotel\Http\Models\Kamar\Room;

class HomeController extends ApiController
{
    public function facility()
    {
        $data = Facility::limit(3)->get();
        return response()->json($data);
    }

    public function room()
    {
        $data = Room::with(/* 'first_detailroom',  */'rrmroom', 'rrmroom.roomfacility')->limit(3)->get();
        return response()->json($data);
    }
}
