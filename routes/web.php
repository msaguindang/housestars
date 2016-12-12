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
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/agency', function () {
    return view('agency');
});

Route::get('/trades-services', function () {
    return view('trades-services');
});

Route::get('/customer', function () {
    return view('customer');
});

Route::get('/about', function () {
    return view('about');
});
