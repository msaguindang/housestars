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

    protected $appends = ['reviewee_name', 'reviewer_name'];

    public function user()
    {	
    	return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }

    public function potential_customer()
    {
    	return $this->belongsTo(PotentialCustomer::class, 'reviewer_id', 'id');
    }

    public function reviewee()
    {
    	return $this->belongsTo(User::class, 'reviewee_id', 'id');
    }

    public function scopeSearchReview($query, $search, $fromDate, $toDate, $searchReviewee, $searchReviewer, $searchTitle, $searchContent, $searchCreatedAt)
    {
        $search = "%" . $search . "%";
        $searchReviewee = "'%" . $searchReviewee . "%'"; 
        $searchReviewer = "'%" . $searchReviewer . "%'"; 
        $searchTitle = "'%" . $searchTitle . "%'"; 
        $searchContent = "'%" . $searchContent . "%'";
        $searchCreatedAt = "%" . $searchCreatedAt . "%";

        $query
            ->leftJoin('potential_customers as pc', 'reviews.reviewer_id', '=', 'pc.id')
            ->leftJoin('users as u1', 'reviews.reviewer_id', '=', 'u1.id')
            ->leftJoin('users as u2', 'reviews.reviewee_id', '=', 'u2.id');

        if(!is_query_empty($search)) {
            $query
                ->where(function ($sub) use ($search) {
                    $sub
                        ->where('reviews.title', 'LIKE', $search)
                        ->orWhere('reviews.content', 'LIKE', $search)
                        ->orWhere('u1.name', 'LIKE', $search)
                        ->orWhere('u1.email', 'LIKE', $search)
                        ->orWhere('u2.name', 'LIKE', $search)
                        ->orWhere('u2.email', 'LIKE', $search);
                })
                ->where(function ($sub) {
                    $sub
                        ->whereNotNull('u1.id')
                        ->whereNotNull('u2.id');
                });
        }

        $query
            ->whereRaw("reviews.title LIKE $searchTitle")
            ->whereRaw("reviews.content LIKE $searchContent")
            ->whereRaw("u1.name LIKE $searchReviewer")
            ->whereRaw("u2.name LIKE $searchReviewee");

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
}
