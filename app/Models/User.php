<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'guid',
        'userName',
        'password',
        'name',
        'email',
        'roleId',
        'loaiTaiKhoanId',

        'dienThoaiCaNhan',
        'ngaySinhCaNhan',
        'chucVuCaNhan',
        'tinhThanhPhoCaNhan',
        'clbCaNhan',
        'truongCaNhan',

        'tenClb',
        'vietTatClb',
        'toChucClb',
        'linkFanpageClb',
        'hoTenDaiDienClb',
        'chucVuDaiDienClb',
        'tinhThanhPhoDaiDienClb',

        'createdAt',
        'updatedAt',
        'createdBy',
        'updatedBy'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}