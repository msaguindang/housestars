<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

     protected $table = 'users';

    protected $fillable = [
        'id', 'name', 'email', 'password', 'customer_id', 'social_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
