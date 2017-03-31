<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = true;

    protected $fillable = ['category', 'status'];

    public function scopeSearch($query, $search)
    {
        return $query->where('category', 'LIKE', '%'.$search.'%');
    }
}
