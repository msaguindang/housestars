<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property_meta';

    protected $fillable = ['user_id', 'meta_name', 'meta_value', 'property_code'];


    public function scopeGetProperty($query, $property_code, $meta_name)
    {
    	return $query->where('property_code', $property_code)->where('meta_name', $meta_name);
    }
}
