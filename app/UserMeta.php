<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class UserMeta extends Model
{
	use SoftDeletes;

    protected $table = 'user_meta';

    protected $fillable = ['user_id', 'meta_name', 'meta_value'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function businesses() {
        return DB::table('user_meta')
					->select('user_id', 'meta_name', 'meta_value')
					->where('meta_name', '=', 'trading-name')
					->orWhere('meta_name', '=', 'trading-name')
					->orderBy('meta_value', 'ASC')
					->get();
    }
}
