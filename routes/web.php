<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('general.home');
});

Route::get('/agency', function () {
    return view('general.agency');
});

Route::get('/trades-services', function () {
    return view('general.trades-services');
});

Route::get('/customer', function () {
    return view('general.customer');
});

Route::get('/about', function () {
    return view('general.about');
});

Route::get('/register/agency/step-one', function () {
    return view('register.agency.step-one');
});

Route::get('/register/agency/step-two', function () {
    return view('register.agency.step-two');
});

Route::get('/register/agency/step-three', function () {
    return view('register.agency.step-three');
});

Route::get('/register/agency/step-four', function () {
    return view('register.agency.step-four');
});

Route::get('/register/agency/complete', function () {
    return view('register.agency.complete');
});

Route::get('/register/tradesman/step-one', function () {
    return view('register.tradesman.step-one');
});

Route::get('/register/tradesman/step-two', function () {
    return view('register.tradesman.step-two');
});

Route::get('/register/tradesman/step-three', function () {
    return view('register.tradesman.step-three');
});

Route::get('/register/tradesman/complete', function () {
    return view('register.tradesman.complete');
});

Route::get('/register/customer/step-one', function () {
    return view('register.customer.step-one');
});

Route::get('/register/customer/complete', function () {
    return view('register.customer.complete');
});

Route::get('/dashboard/agency/profile', function () {
    return view('dashboard.agency.profile');
});

Route::get('/dashboard/agency/profile/edit', function () {
    return view('dashboard.agency.edit');
});

Route::get('/dashboard/tradesman/profile', function () {
    return view('dashboard.tradesman.profile');
});

Route::get('/dashboard/tradesman/profile/edit', function () {
    return view('dashboard.tradesman.edit');
});
