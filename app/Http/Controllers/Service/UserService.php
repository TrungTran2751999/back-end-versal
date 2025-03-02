<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\UtilService;
use App\Http\Controllers\Service\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class UserService
{
    public static function getAll(){
        $user = User::where("loaiTaiKhoanId", 2)->select("id", "guid", "userName", "name")->get();
        return response($user,200);
    }
    public static function getAllCaNhan(){
        $user = User::where("loaiTaiKhoanId", 3)->select("id", "guid", "userName", "name")->get();
        return response($user,200);
    }
    public static function getAllPaginate($start, $limit){
        $listUser = DB::select("SELECT 
        id,
        guid,
        userName,
        name,
        email,
        loaiTaiKhoanId,
        dienThoaiCaNhan,
        ngaySinhCaNhan
        FROM user LIMIT ? OFFSET ?", [$limit, $start]);
        return $listUser;
    }
    public static function filterUser($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " (userName LIKE '%$keyWord%' OR name LIKE '%$keyWord%' OR email LIKE '%$keyWord%' OR dienThoaiCaNhan LIKE '%$keyWord%')" 
        : "";

        $tinhThanhPho = $filter["tinhThanhPho"];
        $sqlTinhThanhPho = !UtilService::IsNullOrEmpty($tinhThanhPho) ? " (tinhThanhPhoDaiDienClb LIKE '%$tinhThanhPho%' OR tinhThanhPhoCaNhan LIKE '%$tinhThanhPho%')" : "";

        $loaiTaiKhoan = $filter["loaiTaiKhoan"];
        $sqlLoaiTaiKhoan = $loaiTaiKhoan > 0 ? " loaiTaiKhoanId = $loaiTaiKhoan" : "";

        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlTinhThanhPho, $sqlLoaiTaiKhoan]);
        
        $sql = "SELECT * FROM user $listCondition $sqlPhanTrang";

        return response(DB::select($sql), 200);
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
        $user = User::where("guid",$id)->first();
        if(!$user) return response("User không tồn tại",400);
        $roleUser = RoleUser::where("userId", $user->id)
                            ->where("isDeleted", null)
                            ->orWhere("isDeleted", false)
                            ->get();
        $user->listRole = $roleUser;
        
        return response($user,200);
    }
    public static function login(Request $request){
        $userName = $request->input("userName");
        $password = $request->input("password");
        // $deviceToken = $request->input("token");
        $user = User::where("userName",$userName)
                    ->first();
        
        if(!($user!=null && Hash::check($password, $user->password))) return response("Tên đăng nhập hoặc mật khẩu không tồn tại",400);
        // $user->deviceToken = $deviceToken;
        // $user->save();
        $arrUser = [
            "id"=>$user->roleId,
            "userName"=>$userName,
            "password"=>$password
        ];
        $token = JWTAuth::attempt($arrUser);

        // $response = new Response();
        // $response->cookie("token",$token, 3600*24*365);
        // $response->cookie(cookie("name",$user->name, 3600*24*365)->withHttpOnly(true));
        // $response->withCookie(cookie("id",$user->id, 3600*24*365)->withHttpOnly(true));
        return [
            "token"=>$token,
            "name"=>$user->name,
            "id"=>$user->id,
            "guid"=>$user->guid
        ];
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
        try{
            DB::beginTransaction();
            $validate = $request->validate([
                "userName"=>"required",
                "email"=>"required",
                "passWord"=>"required",
                "name"=>"required",
                "loaiTaiKhoanId"=>"required"
            ]);

            $name = $request->input("userName");
            $checkUser = User::where("userName",$name)->first();

            if($checkUser != null || $checkUser!="") return response("Username đã tồn tại", 400);

            $user = new User();
            $user->userName = $request->input("userName");
            $user->name = $request->input("name");
            $user->password = Hash::make($request->input("password"));
            $user->loaiTaiKhoanId = $request->input("loaiTaiKhoanId");
            $user->email = $request->input("email");
            $user->guid = Str::uuid()->toString();

            $user->tenClb = $request->input("tenClb");
            $user->vietTatClb = $request->input("vietTatClb");
            $user->toChucClb = $request->input("toChucClb");
            $user->linkFanpageClb = $request->input("linkFanpageClb");
            $user->hoTenDaiDienClb = $request->input("hoTenDaiDienClb");
            $user->chucVuDaiDienClb = $request->input("chucVuDaiDienClb");
            $user->tinhThanhPhoDaiDienClb = $request->input("tinhThanhPhoDaiDienClb");

            $user->dienThoaiCaNhan = $request->input("dienThoaiCaNhan");
            $user->ngaySinhCaNhan = $request->input("ngaySinhCaNhan");
            $user->chucVuCaNhan = $request->input("chucVuCaNhan");
            $user->tinhThanhPhoCaNhan = $request->input("tinhThanhPhoCaNhan");
            $user->clbCaNhan = $request->input("clbCaNhan");
            $user->truongCaNhan = $request->input("truongCaNhan");
            
            $user->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
            $user->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');

            $idMax = User::max("id");
            $user->id = $idMax+1;
            $user->save();

            $listRoleId = $request->listRoleId;
            $listRole = [];
            foreach($listRoleId as $roleId){
                $role = new RoleUser();
                $role["roleId"] = $roleId;
                $role['userId'] = $idMax+1;
                array_push($listRole, $role);
            }
            //$user->listRole = $listRole;
            $user->listRole = RoleService::capNhatRole($listRole);
            DB::commit();
            return response($user,200);
        }catch(Exeption $e){
            return response("Lỗi server",500);
            DB::rollback();
        }
    }
    public static function update(Request $request){
        try{
            DB::beginTransaction();
            $validate = $request->validate([
                "id"=>"required",
                "userName"=>"required",
                "name"=>"required",
                "email"=>"required",
                "loaiTaiKhoanId"=>"required"
            ]);
            $user = User::where("guid", $request->input("guid"))
                        ->where("id", $request->input("id"))->first();
            if($user==null || $user=="") response("Tên user ko tồn tại",400);
            $checkUserExist = User::where("userName",$request->input("userName"))
                                      ->where("id", "<>", $request->input("id"))
                                      ->get();
            
            if(!$checkUserExist->isEmpty()){
                return response("Tên user đã tồn tạiiiii",400);
            }
            $user->userName = $request->input("userName");
            $user->name = $request->input("name");
            $password = $request->input("password");
            if($password != null){
                $user->password = Hash::make($request->input("password"));
            }
            $user->email = $request->input("email");
            $user->dienThoaiCaNhan = $request->input("dienThoaiCaNhan");
            $user->ngaySinhCaNhan = $request->input("ngaySinhCaNhan");
            $user->loaiTaiKhoanId = $request->input("loaiTaiKhoanId");
            $loaiTaiKhoanId = $user->loaiTaiKhoanId;

            //ca-nhan
            if($loaiTaiKhoanId == 3){
                $user->chucVuCaNhan = $request->input("chucVuCaNhan");
                $user->tinhThanhPhoCaNhan = $request->input("tinhThanhPhoCaNhan");
                $user->clbCaNhan = $request->input("clbCaNhan");
                $user->truongCaNhan = $request->input("truongCaNhan");
            }
            if($loaiTaiKhoanId == 2){
                //clb
                $user->tenClb = $request->input("tenClb");
                $user->vietTatClb = $request->input("vietTatClb");
                $user->toChucClb = $request->input("toChucClb");
                $user->linkFanpageClb = $request->input("linkFanpageClb");
                $user->hoTenDaiDienClb = $request->input("hoTenDaiDienClb");
                $user->chucVuDaiDienClb = $request->input("chucVuDaiDienClb");
                $user->tinhThanhPhoDaiDienClb = $request->input("tinhThanhPhoDaiDienClb");
            }
            $user->save();
            $listRole = $request->listRole;
            if($loaiTaiKhoanId == 1){
                RoleService::capNhatRole($listRole);
            }
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
    public static function getCountKh($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " (userName LIKE '%$keyWord%' OR name LIKE '%$keyWord%' OR email LIKE '%$keyWord%' OR dienThoaiCaNhan LIKE '%$keyWord%')" 
        : "";

        $tinhThanhPho = $filter["tinhThanhPho"];
        $sqlTinhThanhPho = !UtilService::IsNullOrEmpty($tinhThanhPho) ? " (tinhThanhPhoDaiDienClb LIKE '%$tinhThanhPho%' OR tinhThanhPhoCaNhan LIKE '%$tinhThanhPho%')" : "";

        $loaiTaiKhoan = $filter["loaiTaiKhoan"];
        $sqlLoaiTaiKhoan = $loaiTaiKhoan > 0 ? " loaiTaiKhoanId = $loaiTaiKhoan" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlTinhThanhPho, $sqlLoaiTaiKhoan]);
        
        $sql = "SELECT COUNT(id) as count FROM user $listCondition";

        return response(DB::select($sql), 200);
    }
    public static function updateTaiKhoanAdmin($request){
        $guid = $request->input("id");
        $user = User::where("guid", $guid)->first();
        if($user!=null){
            $name = $request->input("name");
            if($name!="" && $name!=null){
                $user->name = $name;
            }
            $password = $request->input("password");
            if($password!="" && $password!=null){
                $user->password = Hash::make($password);
            }
            $user->save();
            return response("SUCCESS", 200);
        }else{
            return response("FAIL",400);
        }
    }
}
