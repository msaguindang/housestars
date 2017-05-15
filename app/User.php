<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'users';

    protected $fillable = [
        'id', 'name', 'email', 'password', 'customer_id', 'social_id', 'coupon'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function role()
    {
        return $this->hasOne(RoleUsers::class);
    }

    public function usermetas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query
                    ->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%');
    }
}
