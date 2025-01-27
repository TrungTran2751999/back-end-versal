<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\WorkApi;
use App\Http\Controllers\Api\UserApi;
use App\Http\Controllers\Api\RoleApi;
use App\Http\Controllers\Api\TinTucApi;
use App\Http\Controllers\Api\TheLoaiGameApi;
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

        Route::prefix("/user")->group(function(){
            Route::post("/",[UserApi::class,'getAllPaginate']);
            Route::get("/chi-tiet",[UserApi::class,'getById']);
            Route::post("/update",[UserApi::class,'update']);
            Route::post("/filter", [UserApi::class, 'filterUser']);
            Route::post("/count", [UserApi::class, 'getCount']);
        });

        Route::prefix("/tin-tuc")->group(function(){
            Route::post("/", [TinTucApi::class, 'getAll']);
            Route::get("/chi-tiet", [TinTucApi::class, 'getById']);
            Route::post("/count", [TinTucApi::class, 'getCount']);
            Route::post("/create", [TinTucApi::class, 'create']);
            Route::post("/update", [TinTucApi::class, 'update']);
            Route::prefix("/loai-tin-tuc")->group(function(){
                Route::post("/", [TinTucApi::class, 'getAllLoaiTinTuc']);
                Route::get("/active", [TinTucApi::class, 'getAllActive']);
                Route::post("/create", [TinTucApi::class, 'createLoaiTinTuc']);
                Route::post("/count", [TinTucApi::class, 'getCountLoaiTinTuc']);
                Route::get("/chi-tiet", [TinTucApi::class, 'getLoaiTinTucById']);
                Route::post("/update", [TinTucApi::class, 'updateLoaitinTuc']);
            });
        });

        Route::prefix("/tournament")->group(function(){
            Route::prefix("/the-loai-game")->group(function(){
                Route::post("/", [TheLoaiGameApi::class, 'getAll']);
                Route::get("/chi-tiet", [TheLoaiGameApi::class, 'getById']);
                Route::post("/create", [TheLoaiGameApi::class, 'create']);
                Route::post("/update", [TheLoaiGameApi::class, 'update']);
            });
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