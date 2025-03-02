<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;
    protected $table = 'user_role';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'roleId',
        'userId',
        'isDeleted'
    ];
}
