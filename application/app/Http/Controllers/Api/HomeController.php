<?php

namespace TheFarrelHotel\Http\Controllers\Api;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\ApiController;

use TheFarrelHotel\Http\Models\Facility;
use TheFarrelHotel\Http\Models\Kamar\Room;
use TheFarrelHotel\Http\Models\Pengaturan\Banner;

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
    public function banner()
    {
        $data = Banner::orderBy("urutan", "asc")->get();
        return response()->json($data);
    }

    public function socialMedia()
    {
        $data = \DB::table('social_medias')->first();
        return response()->json($data);
    }

    public function contact()
    {
        $data = \DB::table('contacts')->first();
        return response()->json($data);
    }
}
