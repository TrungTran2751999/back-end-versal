<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'team';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'description',
        'image',
        'theLoaiGameId',
        'userId',
        'createdBy',
        'updatedBy',
        'updatedAt',
        'createdAt',
        'status'
    ];
}
