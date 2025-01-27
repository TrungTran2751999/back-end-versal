<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheLoaiGame extends Model
{
    protected $table = 'the_loai_game';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'tenVietTat',
        'isDeleted',
        'image',
        'createdAt',
        'updatedAt',
        'createdBy',
        'updatedBy'
    ];
}
