<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'reviews';
    public $timestamps = true;

    protected $fillable = [
        'reviewee_id', 'reviewer_id', 'communication', 'work_quality', 'price', 'punctuality', 'attitude', 'title', 'content', 'helpful',

    ];

}
