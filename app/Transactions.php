<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';

    protected $fillable = ['user_id', 'tradesman_id', 'amount_spent', 'receipt'];
}
