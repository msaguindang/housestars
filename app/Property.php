<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property_meta';

    protected $fillable = ['user_id', 'meta_name', 'meta_value', 'property_code'];
}
