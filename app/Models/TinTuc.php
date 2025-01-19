<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    protected $table = 'tin_tuc';
    protected $fillable = [
        'id',
        'content',
        'userId',
        'createdAt',
        'updatedAt',
        'createdBy',
        'updatedBy',
        'status'
    ];
}
