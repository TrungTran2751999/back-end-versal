<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Models\TinTuc;
use App\Models\LoaiTinTuc;
use Carbon\Carbon;
use DB;

class TinTucService
{
    // public const CHUA_DUYET = 0;
    // public const DA_DUYET = 1;
    // public const LAM_LAI = 2;
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
        $tinTuc->status = 0;
    }
    public static function createLoaiTinTuc(){
        $validate = $request->validate([
            "name"=>"required",
            "updatedBy"=>"required"
        ]);
        $checkTinTuc = LoaiTinTuc::where("name", $name)->first();
        if($checkTinTuc==null || $checkTinTuc=="") return response("Tên đã tồn tại", 400);
        $loaiTinTuc = new LoaiTinTuc();
        $loaiTinTuc->name = $request->input("name");
        $loaiTinTuc->createdBy = $request->input("updatedBy");
        $loaiTinTuc->updatedBy = $request->input("updatedBy");
        $loaiTinTuc->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $loaiTinTuc->save();
    }
}
