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
