<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Models\TinTuc;
use Carbon\Carbon;
use DB;

class TinTucService
{
    public static function getAll(){
        return TinTuc::get();
    }
    public static function create($request){
        $name = $request->input("name");
        $checkTinTuc = TinTuc::where("name", $name)->first();
        if($checkTinTuc != null) return response("Tên đã tồn tại", 400);

        $tinTuc = new TinTuc();
        $tinTuc->name = $request->input("name");
        $tinTuc->content = $request->input("content");
        $tinTuc->userId = $request->input("userId");
        $tinTuc->loaiTinTucId = $request->input("loaiTinTucId");
        $tinTuc->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $tinTuc->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $tinTuc->status = "";
    }
}
