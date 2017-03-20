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

    function socialProviders() {
        return $this->hasMany(SocialProvider::class);
    }

    public function role()
    {
        return $this->hasOne(RoleUsers::class);
    }
}
