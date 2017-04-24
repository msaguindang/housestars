<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';
    public $timestamps = true;
    const ACTIVE = 1;
    const MIN = 0;
    const MAX = 3;

    protected $fillable = [
        'name', 'type', 'status', 'user_id', 'priority', 'image_path', 'page'
    ];

    public function scopeGetByPage($query, $page = 'home', $isActive = null)
    {
    	$active = $isActive ? : self::ACTIVE;

    	return $query->where('page', $page)->where('status', $active);
    }

    public function scopeHasPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeRandomPriority($query, $hasPriority)
    {
        if($hasPriority) {
            $priority = rand(self::MIN, self::MAX);
            return $query->where('priority', ($priority > self::MIN ? self::ACTIVE : self::MIN) );
        }
        return $query;
    }
}
