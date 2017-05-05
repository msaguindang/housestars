<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTime;
use DB;

class Reviews extends Model
{
    protected $table = 'reviews';
    public $timestamps = true;

    protected $fillable = [
        'reviewee_id', 'reviewer_id', 'communication', 'work_quality', 'price', 'punctuality', 'attitude', 'title', 'content', 'helpful', 'user_type', 'status'
    ];

    protected $appends = ['reviewee_name', 'reviewer_name', 'business'];

    public function user()
    {	
    	return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }

    public function user_meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'reviewee_id');
    }

    public function potential_customer()
    {
    	return $this->belongsTo(PotentialCustomer::class, 'reviewer_id', 'id');
    }

    public function reviewee()
    {
    	return $this->belongsTo(User::class, 'reviewee_id', 'id');
    }

    public function scopeSearchReview($query, $search, $fromDate, $toDate, $searchReviewee, $searchReviewer, $searchTitle, $searchContent, $searchCreatedAt, $searchBusiness)
    {
        $search = "%" . $search . "%";
        $searchCreatedAt = "%" . $searchCreatedAt . "%";

        $searchFields = [
            'reviews.title'     => "%" . $searchTitle . "%",
            'reviews.content'   => "%" . $searchContent . "%",
            'u1.name'           => "%" . $searchReviewer . "%",
            'u2.name'           => "%" . $searchReviewee . "%",
            'um.meta_value'     => "%" . $searchBusiness . "%"
        ];

        $query
            ->leftJoin('potential_customers as pc', 'reviews.reviewer_id', '=', 'pc.id')
            ->leftJoin('users as u1', 'reviews.reviewer_id', '=', 'u1.id')
            ->leftJoin('users as u2', 'reviews.reviewee_id', '=', 'u2.id')
            ->leftJoin('user_meta as um', function ($join) {
                $join
                    ->on('reviews.reviewee_id', '=', 'um.user_id')
                    ->where('um.meta_name', '=', 'agency-name');
            });

        if(!is_query_empty($search)) {
            $query
                ->where(function ($sub) use ($search) {
                    $sub
                        ->where('reviews.title', 'LIKE', $search)
                        ->orWhere('reviews.content', 'LIKE', $search)
                        ->orWhere('u1.name', 'LIKE', $search)
                        ->orWhere('u1.email', 'LIKE', $search)
                        ->orWhere('u2.name', 'LIKE', $search)
                        ->orWhere('u2.email', 'LIKE', $search)
                        ->orWhere('um.meta_value', 'LIKE', $search);
                })
                ->where(function ($sub) {
                    $sub
                        ->whereNotNull('u1.id')
                        ->whereNotNull('u2.id');
                });
        }

        foreach ($searchFields as $key => $value) {
            if (!is_query_empty($value)) {
                $query->where($key, 'LIKE', $value);
            }
        }

        if(!is_query_empty($searchCreatedAt)) {
            $query->where(function ($sub) use ($searchCreatedAt) {
                $sub
                    ->where(DB::raw("DATE_FORMAT(reviews.created_at, '%b %e, %Y')"), 'LIKE', $searchCreatedAt)
                    ->orWhere(DB::raw("DATE_FORMAT(reviews.created_at, '%M %e, %Y')"), 'LIKE', $searchCreatedAt);
            });
        }

        if(!empty($fromDate) && !empty($toDate)) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            
            $query->whereBetween('reviews.created_at', [$fromDate, $toDate]);
        }

        return $query;
    }

    public function getRevieweeNameAttribute()
    {
    	return $this->reviewee ? $this->reviewee->name : '';
    }

    public function getReviewerNameAttribute()
    {
    	return $this->{$this->user_type} ? $this->{$this->user_type}->name : '';
    }

    public function getBusinessAttribute()
    {
        if($userMeta = $this->user_meta->where('meta_name', 'agency-name')->first()) {
            return $userMeta->meta_value;
        }
        return ''; 
    }
}
