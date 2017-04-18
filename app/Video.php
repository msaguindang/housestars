<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = ['url', 'page', 'status'];


    public function scopeSearch($query, $searchQuery)
    {
    	return $query
    				->whereRaw("url LIKE '%$searchQuery%'")
					->orWhereRaw("page LIKE '%$searchQuery%'");
    }

    public function scopeFilter($query, $filter, $searchUrl, $searchPage)
    {
    	return $query
    				->whereRaw("page LIKE '%$filter%'")
					->whereRaw("url LIKE '%$searchUrl%'")
					->whereRaw("page LIKE '%$searchPage%'");
    }

    public function scopeSearchByRangeDate($query, $fromDate, $toDate)
    {
        if(!empty($fromDate) && !empty($toDate)) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    }

    public function scopeSearchByDateCreated($query, $searchCreatedAt)
    {
    	if (!is_query_empty($searchCreatedAt)) {
			$searchCreatedAt = "%" . $searchCreatedAt . "%";
			$query
                ->where(DB::raw("DATE_FORMAT(created_at, '%b %e, %Y')"), 'LIKE', $searchCreatedAt)
                ->orWhere(DB::raw("DATE_FORMAT(created_at, '%M %e, %Y')"), 'LIKE', $searchCreatedAt);
		}
		return $query;
    }
}
