<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Models\TinTuc;
use App\Models\LoaiTinTuc;
use App\Http\Controllers\Util\UtilService;
use Carbon\Carbon;
use DB;

class TinTucService
{
    // public const CHUA_DUYET = 0;
    // public const DA_DUYET = 1;
    public static function getAll($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " name LIKE '%$keyWord%'" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " status = $status" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus]);

        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";
        
        $sql = "SELECT * FROM tin_tuc $listCondition $sqlPhanTrang";
        
        return response(DB::select($sql), 200);
    }
    public static function create($request){
        $validate = $request->validate([
            "name"=>"required",
            "updatedBy"=>"required",
            "content"=>"required",
        ]);
        $name = $request->input("name");
        $checkTinTuc = TinTuc::where("name", $name)->first();
        if($checkTinTuc != null) return response("Tên tin tức đã tồn tại", 400);

        $tinTuc = new TinTuc();
        $tinTuc->name = $request->input("name");
        $tinTuc->content = $request->input("content");
        $tinTuc->userId = $request->input("userId");
        $tinTuc->loaiTinTucId = $request->input("loaiTinTucId");
        $tinTuc->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $tinTuc->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $tinTuc->updatedBy = 0;
        $tinTuc->status = 0;
    }
    //----------LOAI TIN TUC---------------------------------------------
    public static function getAllLoaiTinTuc($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " name LIKE '%$keyWord%'" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " isDeleted = $status" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus]);

        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";
        
        $sql = "SELECT * FROM loai_tin_tuc $listCondition $sqlPhanTrang";
        
        return response(DB::select($sql), 200);
    } 
    public static function countLoaiTinTuc($filter, $start){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " name LIKE '%$keyWord%'" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " isDeleted = $status" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus]);
        
        $sql = "SELECT COUNT(id) as count FROM loai_tin_tuc $listCondition";

        return response(DB::select($sql), 200);
    }  
    public static function getByIdLoaiTintuc($id){
        return LoaiTinTuc::where("id", $id)->first();
    }
    public static function createLoaiTinTuc($request){
        $validate = $request->validate([
            "name"=>"required",
            "updatedBy"=>"required"
        ]);
        $name = $request->input("name");
        if($name==null || $name=="") return response("Tên không hợp lệ", 400);
        $checkLoaiTinTuc = LoaiTinTuc::where("name", $name)->first();
        if($checkLoaiTinTuc!=null || $checkLoaiTinTuc!="") return response("Tên đã tồn tại", 400);
        $loaiTinTuc = new LoaiTinTuc();
        $loaiTinTuc->name = $request->input("name");
        $loaiTinTuc->createdBy = $request->input("updatedBy");
        $loaiTinTuc->updatedBy = $request->input("updatedBy");
        $loaiTinTuc->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $loaiTinTuc->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $loaiTinTuc->isDeleted = 0;
        $loaiTinTuc->id = LoaiTinTuc::max("id") + 1;
        $loaiTinTuc->save();
        return response("OK", 200);
    }
    public static function updateLoaiTinTuc($request){
        $validate = $request->validate([
            "id"=>"required",
            "name"=>"required",
            "isDeleted"=>"required",
            "updatedBy"=>"required"
        ]);
        $name = $request->input("name");
        $id = $request->input("id");
        if($name==null || $name=="") return response("Tên không hợp lệ", 400);

        $checkLoaiTinTuc = LoaiTinTuc::where("name", $name)->where("id","<>", $id)->where("isDeleted", true)->first();

        if($checkLoaiTinTuc!=null || $checkLoaiTinTuc!=""){
            return response("Tên đã tồn tại", 400);
        }

        $loaiTinTuc = LoaiTinTuc::where("id", $id)->first();
        
        $loaiTinTuc->name = $request->input("name");
        $loaiTinTuc->updatedBy = $request->input("updatedBy");
        $loaiTinTuc->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $loaiTinTuc->isDeleted = $request->input("isDeleted");
        $loaiTinTuc->save();
        return response("OK", 200);
    }
}
