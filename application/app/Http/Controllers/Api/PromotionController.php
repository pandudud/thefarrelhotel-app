<?php

namespace TheFarrelHotel\Http\Controllers\Api;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\ApiController;

use TheFarrelHotel\Http\Models\Promotion;

class PromotionController extends ApiController
{
    public function index(Request $request)
    {
        $page = $request->page ?: 1;
        $pageSize = $request->page_size ?: 10;

        $data = Promotion::with('detailpromotion')->paginate($pageSize);
        $dataPaginate = $data->toArray();
        $return = [
            'data' => $dataPaginate['data'],
            'pagination' => array_except($dataPaginate, ['data'])
        ];
        return response()->json($return);
    }

    public function show($slug)
    {
        $data = Promotion::with('detailpromotion')
                    ->where('promotion_name_slug', $slug)->first();
        if($data) return response()->json($data);
        return response()->json('No Data Found', 404);
    }
}
