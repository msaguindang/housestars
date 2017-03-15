<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    protected $table = 'agents';
    public $timestamps = true;
    protected $fillable = ['agent_id', 'agency_id', 'active'];

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id', 'id');
    }

    public function meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'agency_id');
    }
}
