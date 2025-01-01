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
                $checkRoleExist = RoleUser::where("roleId", $listRole[$i]->roleId)
                                          ->where("userId", $listRole[$i]->userId)
                                          ->first();
                $newRole = new RoleUser();
                $newRole->roleId = $listRole[$i]->roleId;
                $newRole->userId = $listRole[$i]->userId;
                $newRole->id = RoleUser::max("id")+1;
                $newRole->save();
                
                // if($checkRoleExist!=null){
                //     $checkRoleExist->roleId = $listRole[$i]->roleId;
                //     $checkRoleExist->userId = $listRole[$i]->userId;
                //     $checkRoleExist->save();
                // }else{
                //     $newRole = new RoleUser();
                //     $newRole->roleId = $listRole[$i]->roleId;
                //     $newRole->userId = $listRole[$i]->roleId;
                //     $newRole->id = RoleUser::max("id")+1;
                //     $newRole->save();
                // }
                
            }
            return $listRole;
            DB::commit();
        // }catch(Exeption $e){
        //     return response("Lỗi server",500);
        //     DB::rollback();
        // }
       
    }
}
