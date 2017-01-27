<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

     protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'customer_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
