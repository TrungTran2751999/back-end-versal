<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    protected $table = 'tin_tuc';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'content',
        'guid',
        'createdAt',
        'updatedAt',
        'createdBy',
        'updatedBy',
        'status'
    ];
}
