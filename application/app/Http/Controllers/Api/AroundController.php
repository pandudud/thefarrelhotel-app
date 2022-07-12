<?php

namespace TheFarrelHotel\Http\Controllers\Api;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\Controller;
use TheFarrelHotel\Http\Models\Around;

class AroundController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ?: 1;
        $pageSize = $request->page_size ?: 6;

        $data = Around::paginate($pageSize);
        $dataPaginate = $data->toArray();
        $return = [
            'data' => $dataPaginate['data'],
            'pagination' => array_except($dataPaginate, ['data'])
        ];
        return response()->json($return);
    }
}
