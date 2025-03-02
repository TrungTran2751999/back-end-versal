<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\RoleService;

class RoleApi extends Controller
{
    public function getAll(){
        return RoleService::getAll();
    }
}
