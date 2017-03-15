<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    protected $table = 'role_users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'role_id',
    ];
}
