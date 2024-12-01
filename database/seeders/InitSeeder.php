<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ROLE
        $listRole = [
            [
                "id"=>1,
                "name"=>"ADMIN"
            ],
            [
                "id"=>2,
                "name"=>"PARTNER"
            ],
            [
                "id"=>3,
                "name"=>"PLAYER"
            ],
        ];
        for($i=0; $i<count($listRole); $i++){
            $role = new Role();
            $role->id = $listRole[$i]["id"];
            $role->name = $listRole[$i]["name"];
            $role->save();
        }

        $user = new User();
        $user->id = 1;
        $user->name = 'admin';
        $user->guid = Str::uuid()->toString();
        $user->userName = 'user';
        $user->email = 'user12345678@gmail.com';
        $user->position = 'Project Manager';
        $user->coporation = 'DTS';
        $user->password = Hash::make('123456');
        $user->roleId = 1;
        $user->imageId = null;
        $user->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $user->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $user->createdBy = 1;
        $user->updatedBy = 1;
        $user->save();

        $user = new User();
        $user->id = 2;
        $user->name = 'adminMaster';
        $user->guid = Str::uuid()->toString();
        $user->userName = 'adminMaster';
        $user->email = 'user87654321@gmail.com';
        $user->position = 'Admin Master';
        $user->coporation = 'DTS';
        $user->password = Hash::make('987654321');
        $user->roleId = 1;
        $user->imageId = null;
        $user->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $user->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $user->createdBy = 1;
        $user->updatedBy = 1;
        $user->save();
        
    }
}
