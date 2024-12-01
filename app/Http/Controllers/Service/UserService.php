<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\UtilService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class UserService extends Controller
{
    public static function getAll(){
        $user = User::select("id", "userName", "name","passWord")->get();
        return response($user,200);
    }
    // public static function getMemberTeam(){
    //     $user = User::leftJoin("image", 'user.imageId', '=', 'image.id')
    //                 ->select("user.id","user.name", "user.position", "user.coporation","image.path as image")
    //                 ->where("userName","<>","adminMaster")
    //                 ->where("user.roleId",1)
    //                 ->orWhere("user.roleId",2)
    //                 ->orderByDesc("updatedAt")
    //                 ->get();
    //     return response($user,200);
    // }

    // public static function getAllClient(){
    //     $user = User::leftJoin("image", 'user.imageId', '=', 'image.id')
    //                 ->select("user.id","user.name", "user.position", "user.coporation","image.path as image")
    //                 ->where("userName","<>","adminMaster")
    //                 ->orderByDesc("updatedAt")
    //                 ->get();
    //     return response($user,200);
    // }

    public static function getById($id){
        $user = User::where("id",$id)->first();
        if(!$user) return response("User không tồn tại",400);
        
        return response($user,200);
    }

    public static function login($request){
        $userName = $request->input("userName");
        $password = $request->input("password");
        $deviceToken = $request->input("token");
        $user = User::where("userName",$userName)
                    ->first();
        
        if(!$user || !Hash::check($password,$user->password)) return response("Tên đăng nhập hoặc mật khẩu không tồn tại",400);
        $user->deviceToken = $deviceToken;
        $user->save();
        $arrUser = [
            "id"=>$user->id,
            "userName"=>$userName,
            "password"=>$password,
        ];
        $token = JWTAuth::attempt($arrUser);

        $response = new Response();
        $response->cookie("token",$token, 3600*24*365);
        $response->cookie(cookie("name",$user->name, 3600*24*365)->withHttpOnly(false));
        $response->withCookie(cookie("id",$user->id, 3600*24*365)->withHttpOnly(false));
        return $response;
    }

    public static function logout(){

        $response = new Response();
        $response->withCookie(Cookie::forget('token'));
        $response->withCookie(Cookie::forget('name'));
        $response->withCookie(Cookie::forget('id'));
        return $response;
    }

    public static function create(Request $request){
        $validate = $request->validate([
            "userName"=>"required",
            "passWord"=>"required",
            "name"=>"required",
        ]);

        $name = $request->input("userName");
        $checkUser = User::where("userName",$name)->first();

        if($checkUser) return response("Username đã tồn tại", 400);

        $user = new User();
        $user->userName = $request->input("userName");
        $user->name = $request->input("name");
        $user->password = Hash::make($request->input("password"));
        

        $idMax = User::max("id");
        $user->id = $idMax+1;
        $user->save();
        return response($user,200);
    }

    public static function update($request){
        try{
            DB::beginTransaction();
            $validate = $request->validate([
                "id"=>"required",
                "userName"=>"required",
                "name"=>"required",
            ]);
            $checkUserExist = User::where("userName",$request->input("userName"))
                                      ->where("id", "<>", $request->input("id"))
                                      ->get();
            
            if(!$checkUserExist->isEmpty()){
                return response("Tên user đã tồn tại",400);
            }
            $user->userName = $request->input("userName");
            $user->name = $request->input("name");
           
            $user->save();
            DB::commit();
        }catch(Exeption $e){
            return response("Lỗi server",500);
            DB::rollback();
        }
    }

    public static function changePass($request){
        $validate = $request->validate([
            "id"=>"required",
            "password"=>"required",
        ]);

        $user = User::where("id", $request->input("id"))
                      ->first();
        $passwordFromDB = $user->password;
        $oldPassword = $request->input("oldPassword");
        if(!$user){
            return response("User không tồn tại",400);
        }
        $user->password = Hash::make($request->input("password"));
        $user->save();
        return "OK";
    }
    public static function getDeviceToken(){
        return User::select("deviceToken")->get();
    }
}
