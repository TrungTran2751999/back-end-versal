<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\WorkApi;
use App\Http\Controllers\Api\UserApi;
use App\Http\Controllers\Api\RoleApi;
use App\Http\Controllers\ClientController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//============================API==============================
Route::prefix("/api")->group(function(){
    Route::prefix("/admin")->group(function(){
        Route::post("/login",[UserApi::class,'login']);
        Route::post("/register",[UserApi::class,'create']);

        Route::prefix("/role")->group(function(){
            Route::get("/",[RoleApi::class,'getAll']);
        });
    });
    // ==============USER==============
    // Route::prefix("/user")->group(function(){
    //     Route::get("/",[UserApi::class,'getAll']);
    //     Route::post("/",[UserApi::class,'create']);
    //     Route::post("/update",[UserApi::class,'update']);
    //     Route::get("/detail",[UserApi::class,'getById']);

    //     Route::post("/login",[UserApi::class,'login']);
    //     Route::get("/logout",[UserApi::class,'logout']);
    //     Route::post('/change-pass', [UserApi::class,'changePass']);
        
    // });
    //==============WORK================
    // Route::prefix("/work")->group(function(){
    //     Route::get("/",[WorkApi::class,'getAll']);
    //     Route::get("/detail",[WorkApi::class,'getById']);
    //     Route::post("/",[WorkApi::class,'create']);
    //     Route::post("/update",[WorkApi::class,'update']);
    //     Route::get("/delete",[WorkApi::class,'delete']);
    //     Route::get("/notificate", [WorkApi::class,'sendNotificate']);
    // });
    
});

//==========================ROUTE===============================
Route::prefix('/')->group(function(){
    Route::get('/', function () {
        return view('index');
    });
    //Route::get('/', [ClientController::class,'index']);
    // Route::prefix('/Blog')->group(function(){
    //     Route::get('/', [ClientController::class,'blog']);
    //     Route::get('/detail', [ClientController::class,'blogDetail']);
    // });
    // Route::prefix('/courses')->group(function(){
    //     Route::get('/', [ClientController::class,'course']);
        
    // });
});