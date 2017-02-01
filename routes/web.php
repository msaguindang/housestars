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

Route::get('/profile', 'MainController@dashboard');

Route::get('/', function () {
    Sentinel::disableCheckpoints();
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

Route::get('/register/agency/step-one', 'RegistrationController@Agency')->middleware('agency');

Route::get('/register/agency/step-two', function () {
    
    if(session()->exists('completed')){
        return redirect('/');
    } else {
        return view('register.agency.step-two');
    }
})->middleware('agency');

Route::get('/register/agency/step-three', 'RegistrationController@Payment')->middleware('agency');

Route::get('/register/agency/step-four', 'RegistrationController@Review')->middleware('agency');

Route::get('/register/agency/complete', function () {
    return view('register.agency.complete');
})->middleware('agency');

Route::get('/register/tradesman/step-one', 'RegistrationController@Tradesman')->middleware('tradesman');

Route::get('/register/tradesman/step-two', 'RegistrationController@Payment')->middleware('tradesman');

Route::get('/register/tradesman/step-three', 'RegistrationController@Review')->middleware('tradesman');

Route::get('/register/tradesman/complete', function () {
    return view('register.tradesman.complete');
})->middleware('tradesman');

Route::get('/register/customer/step-one', function () {
    return view('register.customer.step-one');
});

Route::get('/register/customer/complete', function () {
    return view('register.customer.complete');
});

Route::get('/dashboard/agency/profile', 'AgencyController@dashboard')->middleware('agency');

Route::get('/dashboard/agency/edit', 'AgencyController@edit')->middleware('agency');
Route::get('/dashboard/agency/settings', 'AgencyController@settings')->middleware('agency');

Route::get('/dashboard/tradesman/profile', 'TradesmanController@dashboard')->middleware('tradesman');

Route::get('/dashboard/tradesman/edit', 'TradesmanController@edit')->middleware('tradesman');

Route::get('/dashboard/tradesman/settings', 'TradesmanController@settings')->middleware('tradesman');

Route::get('/dashboard/customer/profile', function () {
    return view('dashboard.customer.profile');
});

Route::get('/dashboard/customer/edit', function () {
    return view('dashboard.customer.edit');
});

Route::get('/search-category', function () {
    return view('general.search-category');
});

Route::get('/category-listings', function () {
    return view('general.category-listings');
});

Route::get('/tradesman-listings', function () {
    return view('general.tradesman-listings');
});

Route::get('/agency-listings', function () {
    return view('general.agency-listings');
});

Route::get('/savings-calculator', function () {
    return view('general.savings-calculator');
});


Route::post('/register', 'RegistrationController@postRegister');

Route::post('/login', 'LoginController@postLogin');

Route::post('/logout', 'LoginController@logout');

Route::post('/add-info', 'RegistrationController@postUserMeta');

Route::post('/add-agents', 'RegistrationController@postAddAgents');

Route::post('/add-payment', 'RegistrationController@postPayment');

Route::post('/charge', 'RegistrationController@postCharge');

Route::post('/update-profile', 'AgencyController@updateProfile');

Route::post('/update-settings', 'AgencyController@updateSettings');

Route::post('/update-payment', 'AgencyController@updatePayment');

Route::post('/delete-agent', 'AgencyController@deleteAgent');

Route::post('/update-agents', 'AgencyController@updateAgent');

Route::post('upload', 'TradesmanController@upload');

Route::post('tradesman/update-profile', 'TradesmanController@updateProfile');

Route::post('/delete-item', 'TradesmanController@deleteItem');





