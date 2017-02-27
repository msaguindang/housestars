<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLogin()
    {
        
    }

    public function showDashboard()
    {
        dump('dashboard');
    }

    public function showMembers()
    {
        dump('members');
    }

    public function showProperties()
    {
        dump('properties');
    }

    public function showReviews()
    {
        dump('reviews');
    }

    public function showAdvertisements()
    {
        dump('advertisements');
    }
}
