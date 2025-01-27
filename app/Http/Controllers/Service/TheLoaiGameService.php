<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;

class TheLoaiGameService
{
    public static function filter(){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " (name LIKE '%$keyWord%' OR tenVietTat LIKE '%$keyWord%')" 
        : "";

        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord]);
        
        $sql = "SELECT * FROM the_loai_game $listCondition $sqlPhanTrang";

        return response(DB::select($sql), 200);
    }
}
