<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\TinTucService;
use App\Models\TinTuc;

class TinTucApi extends Controller
{
    public function getAll(){
        return TinTucService::getAll();
    }
    public function create(){
        
    }
}
