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
                    ->join('users', 'users.id', '=', 'user_meta.user_id')
					->select('user_meta.user_id', 'user_meta.meta_name', 'user_meta.meta_value')
					->where('user_meta.meta_name', '=', 'trading-name')
					->orWhere('user_meta.meta_name', '=', 'trading-name')
					->orderBy('user_meta.meta_value', 'ASC')
					->get();
    }
}
