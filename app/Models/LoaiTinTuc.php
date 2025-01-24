<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LoaiTinTuc extends Model
{
    use HasFactory;
    protected $table = 'loai_tin_tuc';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'createdAt',
        'updatedAt',
        'cratedBy',
        'updatedBy',
        'isDeleted'
    ];
}
