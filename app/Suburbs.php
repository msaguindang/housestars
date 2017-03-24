<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suburbs extends Model
{
    protected $table = 'suburbs';

    protected $fillable = ['id', 'name', 'availability', 'max_tradies', 'max_tradie', 'status', 'latitude', 'longitude', 'created_at', 'updated_at'];
}
