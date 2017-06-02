<?php

namespace App\Services;

use App\Agents;
use App\UserMeta;
use App\Reviews;
use App\User;
use App\Property;
use DB;

class AgentService
{
    public function getData($id)
    {   
        $data = [];
        $data['meta'] = [];
        $data['dp'] = 'assets/default.png';
        $data['cp'] = 'assets/default_cover_photo.jpg';
        if ($agent = Agents::where('agent_id', '=', $id)->first()) {
            $user_id =  $agent->agency_id;
            $meta = UserMeta::where('user_id', $user_id)->get();
            foreach ($meta as $key) {
                if ($key->meta_name == 'profile-photo') {
                    $data['dp'] = $key->meta_value;
                } else if ($key->meta_name == 'cover-photo') {
                    $data['cp'] = $key->meta_value;
                } else {
                    $data[$key->meta_name] = $key->meta_value;
                }
            }
            $data['rating'] = $this->getRating($user_id);
            $data['reviews'] = $this->getReviews($user_id);
            $data['total'] = count($data['reviews']);
            $data['properties'] = $this->property_listing($user_id);
            $data['total-listings'] = count($data['properties']);
        }
        
        return $data;
    }
    
    public function getRating($id)
    {
        $ratings = DB::table('reviews')->where('reviewee_id', '=', $id)->get();
        $average = 0;
        $numRatings = count($ratings);

        foreach ($ratings as $rating) {
            $average = ($average + (int)round(($rating->communication + $rating->work_quality + $rating->price + $rating->punctuality + $rating->attitude) / 5)) / $numRatings;
        }

        return $average;
    }

    public function getReviews($id)
    {
        $reviews = Reviews::where('reviewee_id', '=', $id)->get();
        $data = array(); $x = 0; $average = 0;
        foreach ($reviews as $review) {
            $name = User::where('id', $review->reviewer_id)->get();
            $data[$x]['name'] = $name[0]['name'];
            $data[$x]['average'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
            $data[$x]['communication'] = (int)$review->communication;
            $data[$x]['work_quality'] = (int)$review->work_quality;
            $data[$x]['price'] = (int)$review->price;
            $data[$x]['punctuality'] = (int)$review->punctuality;
            $data[$x]['attitude'] = (int)$review->attitude;
            $data[$x]['title'] = $review->title;
            $data[$x]['content'] = $review->content;
            $data[$x]['created'] = $review->created_at->format('M d, Y');
            $data[$x]['helpful'] = $review->helpful;
            $data[$x]['id'] = $review->id;
            $x++;
        }

        return $data;
    }

    public function property_listing($id)
    {
        $property_meta = Property::where('meta_name', '=', 'agent')->where('meta_value', '=', $id)->get();
        $x = 0;

        foreach ($property_meta as $meta) {
            $prop[$x]['id'] = $meta->user_id;
            $prop[$x]['code'] = $meta->property_code;
            $x++;
        }

        $properties = array();

        if(isset($prop)){
            foreach ($prop as $key) {
                $property = Property::where('user_id', '=', $key['id'])->where('property_code', '=', $key['code'])->get();
                foreach ($property as $meta) {
                    $info[$meta->meta_name] = $meta->meta_value;
                }

                array_push($properties, $info);
            }
        }
        return $properties;
    }

    public function getEditableData($id)
    {
        $data = [];
        
        $user_id =  Agents::where('agent_id', '=', $id)->first()->agency_id;
        $meta = UserMeta::where('user_id', $user_id)->get();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $data['name'] = User::find($id)->name;
        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }
        
        return $data;
    }
}
