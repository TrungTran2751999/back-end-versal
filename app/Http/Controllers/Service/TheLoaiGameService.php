<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Util\UtilService;
use App\Models\TheLoaiGame;
use DB;

class TheLoaiGameService
{
    public static function getAllActive(){
        return TheLoaiGame::where("isDeleted", false)->select("id", "name", "tenVietTat", "isDeleted")->get();
    }
    public static function getAll($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " (name LIKE '%$keyWord%' OR tenVietTat LIKE '%$keyWord%')" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " isDeleted = $status" : "";


        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus]);
        
        $sql = "SELECT * FROM the_loai_game $listCondition $sqlPhanTrang";

        $sqlCount = "SELECT COUNT(id) as count FROM the_loai_game $listCondition";

        $result = [
            "listData"=>DB::select($sql),
            "count"=>DB::select($sqlCount)
        ];

        return response($result, 200);
    }
    public static function getCount(){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " (name LIKE '%$keyWord%' OR tenVietTat LIKE '%$keyWord%')" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status > 0 ? " isDeleted = $status" : "";

        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus]);
        
        $sql = "SELECT COUNT(id) FROM the_loai_game $listCondition $sqlPhanTrang";

        return response(DB::select($sql), 200);
    }
    public static function create($request){
        $validate = $request->validate([
            "name"=>"required",
            "updatedBy"=>"required",
            "tenVietTat"=>"required",
            "image"=>"required"
        ]);
        $name = $request->input("name");
        $tenVietTat = $request->input("tenVietTat");

        $checkTheLoaiGame = TheLoaiGame::where("name", $name)->orWhere("tenVietTat", $tenVietTat)->first();

        if($checkTheLoaiGame!=null) return response("Tên đã tồn tại", 400);
        $theLoaiGame = new TheLoaiGame();
        $theLoaiGame->name = $name;
        $theLoaiGame->tenVietTat = $tenVietTat;
        $theLoaiGame->image = $request->input("image");
        $theLoaiGame->isDeleted = 0;
        $theLoaiGame->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $theLoaiGame->createdBy = 0;
        $theLoaiGame->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $theLoaiGame->updatedBy = 0;
        $theLoaiGame->id = TheLoaiGame::max("id")+1;
        $theLoaiGame->save();
        return response("OK",200);
    }
    public static function update($request){
        $validate = $request->validate([
            "name"=>"required",
            "tenVietTat"=>"required",
            "updatedBy"=>"required",
            "tenVietTat"=>"required",
            "id"=>"required"
        ]);
        $name = $request->input("name");
        $tenVietTat = $request->input("tenVietTat");
        $checkTheLoaiGame = TheLoaiGame::where("name", $tenVietTat)->orWhere("tenVietTat", $tenVietTat)->get();

        if(count($checkTheLoaiGame) > 1) return response("Tên đã tồn tại", 400);
        $id = $request->input("id");
        $theLoaiGame = TheLoaiGame::where("id", $id)->first();
        if($theLoaiGame!=null){
            $theLoaiGame->id = $request->input("id");
            $theLoaiGame->name = $name;
            $theLoaiGame->tenVietTat = $tenVietTat;
            $theLoaiGame->isDeleted = $request->input("isDeleted");
            $image = $request->input("image");
            if($image!=null && $image!=""){
                $theLoaiGame->image = $image;
            }
            $theLoaiGame->save();
            return response("OK",200);
        }
        return response("FAIL", 500);
    }
    public static function getById($id){
        return TheLoaiGame::where("id", $id)->first();
    }
}
