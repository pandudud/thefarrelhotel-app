<?php

namespace TheFarrelHotel\Http\Controllers\Api;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\ApiController;

use TheFarrelHotel\Http\Models\Pengaturan\Banner;

class GeneralsController extends ApiController
{
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
