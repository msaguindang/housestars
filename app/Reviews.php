<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Carbon\Carbon;
use DateTime;

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

    public function scopeSearchReview($query, $search)
    {
        if (!empty($search)) {
            $search = '%' . $search . '%';
            return $query
                    ->leftJoin('potential_customers as pc', 'reviews.reviewer_id', '=', 'pc.id')
                    ->leftJoin('users as u1', 'reviews.reviewer_id', '=', 'u1.id')
                    ->leftJoin('users as u2', 'reviews.reviewee_id', '=', 'u2.id')
                    ->orWhere('reviews.title', 'LIKE', $search)
                    ->orWhere('reviews.content', 'LIKE', $search)
                    ->orWhere('u1.name', 'LIKE', $search)
                    ->orWhere('u1.email', 'LIKE', $search)
                    ->orWhere('u2.name', 'LIKE', $search)
                    ->orWhere('u2.email', 'LIKE', $search)
                    ->where(function ($sub) {
                        $sub
                            ->whereNotNull('u1.id')
                            ->whereNotNull('u2.id');
                    });
        }
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
