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
use App\Http\Controllers\Api\TeamApi;
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

        Route::prefix("/role")->middleware(['auth:api', 'role:0'])->group(function(){
            Route::get("/",[RoleApi::class,'getAll']);
        });

        Route::prefix("/user")->group(function(){
            Route::post("/",[UserApi::class,'getAllPaginate'])->middleware(['auth:api', 'role:0']);
            Route::get("/chi-tiet",[UserApi::class,'getById'])->middleware(['auth:api', 'role:0']);;
            Route::post("/update",[UserApi::class,'update'])->middleware(['auth:api', 'role:0']);;
            Route::post("/filter", [UserApi::class, 'filterUser'])->middleware(['auth:api', 'role:0']);;
            Route::post("/count", [UserApi::class, 'getCount'])->middleware(['auth:api', 'role:0']);;
            Route::get("/active", [UserApi::class, 'getAll'])->middleware(['auth:api', 'role:0']);;
            Route::get("/ca-nhan-active", [UserApi::class, 'getAllCaNhan'])->middleware(['auth:api', 'role:0']);
            Route::post("/update-admin", [UserApi::class, 'updateTaiKhoanAdmin'])->middleware(['auth:api', 'role:0']);
        });

        Route::prefix("/tin-tuc")->group(function(){
            Route::post("/", [TinTucApi::class, 'getAll']);
            Route::get("/chi-tiet", [TinTucApi::class, 'getById'])->middleware(['auth:api', 'role:0']);
            Route::post("/count", [TinTucApi::class, 'getCount']);
            Route::post("/create", [TinTucApi::class, 'create'])->middleware(['auth:api', 'role:0']);
            Route::post("/update", [TinTucApi::class, 'update'])->middleware(['auth:api', 'role:0']);
            Route::post("/duyet-bai", [TinTucApi::class, 'duyetBai'])->middleware(['auth:api', 'role:0']);
            Route::prefix("/loai-tin-tuc")->group(function(){
                Route::post("/", [TinTucApi::class, 'getAllLoaiTinTuc'])->middleware(['auth:api', 'role:0']);
                Route::get("/active", [TinTucApi::class, 'getAllActive']);
                Route::post("/create", [TinTucApi::class, 'createLoaiTinTuc'])->middleware(['auth:api', 'role:0']);
                Route::post("/count", [TinTucApi::class, 'getCountLoaiTinTuc'])->middleware(['auth:api', 'role:0']);
                Route::get("/chi-tiet", [TinTucApi::class, 'getLoaiTinTucById'])->middleware(['auth:api', 'role:0']);
                Route::post("/update", [TinTucApi::class, 'updateLoaitinTuc'])->middleware(['auth:api', 'role:0']);
            });
        });

        Route::prefix("/tournament")->group(function(){
            Route::prefix("/the-loai-game")->group(function(){
                Route::post("/", [TheLoaiGameApi::class, 'getAll']);
                Route::get("/chi-tiet", [TheLoaiGameApi::class, 'getById']);
                Route::post("/create", [TheLoaiGameApi::class, 'create']);
                Route::post("/update", [TheLoaiGameApi::class, 'update']);
                Route::get("/active", [TheLoaiGameApi::class, 'getAllActive']);
            });
            Route::prefix("/team")->group(function(){
               Route::post("/", [TeamApi::class, 'getAll']);
               Route::get("/chi-tiet", [TeamApi::class, 'getById']);
               Route::post("/create", [TeamApi::class, 'create']);
               Route::post("/update", [TeamApi::class, 'update']);
               Route::post("/member", [TeamApi::class, 'getMemberOfTeam']);
               Route::post("/member/add", [TeamApi::class, 'addMemberTeam']);
               Route::post("/member/delete", [TeamApi::class, 'xoaMemberTeam']);
            });
        });
    });
    Route::prefix("/")->group(function(){
        Route::prefix("/tin-tuc")->group(function(){
            Route::get("/", [TinTucApi::class, 'getAllInClient']);
            Route::get("/chi-tiet", [TinTucApi::class, 'getByIdClient']);
            Route::post("/by-loai-tin-tuc", [TinTucApi::class, 'getTinTucByLoaiTinTuc']);
            Route::get("/allow-loai-tin-tuc", [TinTucApi::class, 'getListTinTucByLoaiTinTucInClient']);
        });
        Route::prefix("/loai-tin-tuc")->group(function(){
            Route::get("/chi-tiet", [TinTucApi::class, 'getByIdLoaiTinTucClient']);
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