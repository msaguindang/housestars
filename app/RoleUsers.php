<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    
    protected $table = 'role_users';
    
    protected $primaryKey = 'user_id';

    public $timestamps = true;
    
    protected $fillable = ['user_id', 'role_id'];

    public function scopeHasRole($query, $user_id, $role_id)
    {
    	return $query->where('user_id', $user_id)->where('role_id', $role_id);
    }

    public function definition()
    {
    	return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
