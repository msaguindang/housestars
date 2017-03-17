<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PotentialCustomer extends Model
{
    protected $table = 'potential_customers';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'phone', 'status'];
}
