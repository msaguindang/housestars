<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reviews;

class PotentialCustomer extends Model
{
    protected $table = 'potential_customers';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'phone', 'status'];

    public function reviews()
    {
    	return $this->hasMany(Reviews::class, 'reviewer_id', 'id');
    }
}
