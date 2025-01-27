<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\TheLoaiGameService;

class TheLoaiGameApi extends Controller
{
    public static function filter(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TheLoaiGameService::filter($filter, $start, $limit);
    }
}
