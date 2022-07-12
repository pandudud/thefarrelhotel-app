<?php

namespace TheFarrelHotel\Http\Controllers\Api;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\ApiController;

use TheFarrelHotel\Http\Models\Pengaturan\Banner;

class GeneralsController extends ApiController
{
    public function banner(Request $request)
    {
        $data = Banner::all();
        return response()->json($data);
    }
    public function socialMedia(Request $request)
    {
        $data = \DB::table('social_medias')->first();
        return response()->json($data);
    }
}
