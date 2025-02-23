<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Models\TinTuc;
use App\Models\LoaiTinTuc;
use App\Http\Controllers\Util\UtilService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;

class TinTucService
{
    // public const CHUA_DUYET = 0;
    // public const DA_DUYET = 1;
    public static function getAll($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " tt.name LIKE '%$keyWord%'" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " tt.status = $status" : "";

        $loaiTinTuc = $filter["loaiTinTucId"];
        $sqlLoaiTinTuc = $loaiTinTuc != null ? " ltt.id = $loaiTinTuc" :"";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus, $sqlLoaiTinTuc]);

        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";
        
        $sql = "SELECT 
        tt.*,
        ltt.id as loaiTinTucId,
        ltt.name as tenLoaiTinTuc
        FROM tin_tuc as tt LEFT JOIN loai_tin_tuc as ltt ON tt.loaiTinTucId = ltt.id $listCondition 
        ORDER BY tt.createdAt DESC  $sqlPhanTrang";
        
        return response(DB::select($sql), 200);
    }
    public static function getCount($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " tt.name LIKE '%$keyWord%'" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " tt.status = $status" : "";

        $loaiTinTuc = $filter["loaiTinTucId"];
        $sqlLoaiTinTuc = $loaiTinTuc != null ? " ltt.id = $loaiTinTuc" :"";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus, $sqlLoaiTinTuc]);

        $sql = "SELECT 
        COUNT(tt.id) as count
        FROM tin_tuc as tt LEFT JOIN loai_tin_tuc as ltt ON tt.loaiTinTucId = ltt.id $listCondition";
        return response(DB::select($sql), 200);

    }
    public static function getAllActive(){
        return LoaiTinTuc::where("isDeleted",false)->get();
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
        $tinTuc->guid = Str::uuid()->toString();
        $tinTuc->name = $request->input("name");
        $tinTuc->content = $request->input("content");
        $tinTuc->loaiTinTucId = $request->input("loaiTinTucId");
        $tinTuc->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $tinTuc->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $tinTuc->updatedBy = $request->input("updatedBy");
        $tinTuc->createdBy = $request->input("updatedBy");
        $tinTuc->status = 0;
        $tinTuc->avartar = $request->input("avartar");
        $tinTuc->id = TinTuc::max("id")+1;
        $tinTuc->save();
    }
    public static function getById($id){
        return TinTuc::where("guid", $id)->first();
    }
    public static function getByIdClient($guid, $loaiTinTucId){
        $tinTucClient = [];
        $sqlSelected = "SELECT 
                tt.content, 
                tt.name, 
                tt.avartar, 
                ltt.name as tenLoaiTinTuc,
                tt.updatedAt
                FROM tin_tuc as tt
        LEFT JOIN loai_tin_tuc as ltt ON tt.loaiTinTucId = ltt.id WHERE tt.guid = '$guid'"; 

        $tinTucClient["selected"] = DB::select($sqlSelected);

        $sqlLienQuan = "SELECT 
                tt.content, 
                tt.name, 
                tt.guid,
                tt.avartar, 
                tt.loaiTinTucId,
                ltt.name as tenLoaiTinTuc,
                tt.updatedAt
                FROM tin_tuc as tt
        LEFT JOIN loai_tin_tuc as ltt ON tt.loaiTinTucId = ltt.id 
        WHERE tt.guid <> '$guid'
        AND tt.loaiTinTucId = '$loaiTinTucId'
        ORDER BY tt.createdAt DESC 
        LIMIT 8 OFFSET 0"; 

        $tinTucClient["lienQuan"] = DB::select($sqlLienQuan);

        return response($tinTucClient, 200);
    }
    public static function update($request){
        $validate = $request->validate([
            "id"=>"required",
            "name"=>"required",
            "updatedBy"=>"required",
            "content"=>"required"
        ]);
        $name = $request->input("name");
        $id = $request->input("id");
        $guid = $request->input("guid");
        if($name==null || $name=="") return response("Tên không hợp lệ", 400);

        $checkTinTuc = TinTuc::where("id","<>", $id)
                              ->where("guid","<>", $guid)
                              ->where("name", $name)->first();
        if($checkTinTuc != null) return response("Tên tin tức đã tồn tại", 400);
        $tinTuc = TinTuc::where("id", $id)->where("guid", $guid)->first();
        if($tinTuc != null){
            $tinTuc->name = $name;
            $tinTuc->status = $request->input("status");
            $tinTuc->loaiTinTucId = $request->input("loaiTinTucId");
            $tinTuc->content = $request->input("content");
            $tinTuc->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
            $tinTuc->avartar = $request->input("avartar");
            $tinTuc->save();
            return response("OK",200);
        }
        return reponse("FAIL",500);

    }
    public static function duyetBai($request){
        $validate = $request->validate([
            "id"=>"required",
            "status"=>"required"
        ]);
        $id = $request->input("id");
        $checkTinTuc = TinTuc::where("id", $id)->first();
        $checkTinTuc->status = $request->input("status");
        $checkTinTuc->save();
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
