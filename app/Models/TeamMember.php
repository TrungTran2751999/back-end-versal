<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_member';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'position',
        'userId',
        'teamId',
        'createdAt',
        'updatedAt',
        'createdBy',
        'updatedBy',
        'isDeleted'
    ];
}
