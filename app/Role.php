<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role_users';

    protected $fillable = [
        'user_id', 'role_id',
    ];
}
