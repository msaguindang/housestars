<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';
    public $timestamps = true;

    protected $fillable = [
        'name', 'type', 'status', 'user_id', 'priority', 'image_path'
    ];

}
