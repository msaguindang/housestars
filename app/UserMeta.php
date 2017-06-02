<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserMeta extends Model
{
    protected $table = 'user_meta';

    protected $fillable = ['user_id', 'meta_name', 'meta_value'];

    public static function businesses() {
        return DB::table('user_meta')
					->select('user_id', 'meta_name', 'meta_value')
					->where('meta_name', '=', 'trading-name')
					->orWhere('meta_name', '=', 'trading-name')
					->orderBy('meta_value', 'ASC')
					->get();
    }
}
