<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\UtilService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Work;
use App\Models\Image;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Service\UserService;
use DB;

class WorkService extends Controller
{
    public static function getAll(){
        return Work::orderByDesc("id")->get();
    }
    public static function getById($id){
        $work = Work::where("id",$id)->first();
        if($work){
            return response($work, 200);
        }else{
            return response("NOT FOUND", 404);
        }
    }
    public static function create($request){
        $validate = $request->validate([
            "name"=>"required"
        ]);
        $name = $request->input("name");
        $maxId = Work::max("id");
        $work = new Work();
        $work->id = $maxId+1;
        $work->name = $name;
        $work->save();

        $listDeviceToken = UserService::getDeviceToken();
        UtilService::sendNotificate("Thông báo", "Công việc ".$name." được thêm vào", $listDeviceToken);

        return response("SUCCESS", 200);
    }
    public static function update($request){
        $validate = $request->validate([
            "id"=>"required",
            "name"=>"required"
        ]);
        $work = Work::where("id",$request->input("id"))->first();
        if($work!=null){
            $oldName = $work->name;
            $work->name = $request->input("name");
            $work->save();

            $listDeviceToken = UserService::getDeviceToken();
            UtilService::sendNotificate("Thông báo", "Công việc ".$oldName." được đổi thành".$request->input("name"), $listDeviceToken);
            return response($work, 200);
        }else{
            return response("NOT FOUND", 404);
        }
    }
    public static function delete($id){
        $work = Work::where("id",$id)->first();
        if($work!=null) $work->delete();
        return response("OK",200);
    }
    public static function sendNotificate(){
        $listDeviceToken = UserService::getDeviceToken();
        $res = UtilService::sendNotificate("Thông báo", "cccc", $listDeviceToken);
        return response("ok");
    }
   
}
