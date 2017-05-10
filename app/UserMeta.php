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
					->where('meta_name', '=', 'agency-name')
					->orWhere('meta_name', '=', 'business-name')
					->orderBy('meta_value', 'ASC')
					->get();
    }
}
