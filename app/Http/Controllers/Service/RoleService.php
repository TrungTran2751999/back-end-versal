<?php

namespace App\Http\Controllers\Service;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use DB;

class RoleService
{
    public static function getAll(){
        return Role::get();
    }
    public static function capNhatRole($listRole){
        // try{
            DB::beginTransaction();
            for($i=0; $i < count($listRole); $i++){
                $checkRoleExist = RoleUser::where("roleId", $listRole[$i]['roleId'])
                                          ->where("userId", $listRole[$i]['userId'])
                                          ->first();
                
                if($checkRoleExist==null){
                    $newRole = new RoleUser();
                    $newRole->roleId = $listRole[$i]['roleId'];
                    $newRole->userId = $listRole[$i]['userId'];
                    $newRole->isDeleted = $listRole[$i]['isDeleted'];
                    $newRole->id = RoleUser::max("id")+1;
                    $newRole->save();
                }else{
                    $checkRoleExist->isDeleted = $listRole[$i]['isDeleted'];
                    $checkRoleExist->save();
                }
            }
            DB::commit();
            return $listRole;
        // }catch(Exeption $e){
        //     return response("Lỗi server",500);
        //     DB::rollback();
        // }
       
    }
}
