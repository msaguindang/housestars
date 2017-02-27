<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suburbs extends Model
{
    protected $table = 'suburbs';

    protected $fillable = ['id', 'name', 'availability', 'created_at', 'updated_at'];
}
