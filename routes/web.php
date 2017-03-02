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

Route::group(['prefix' => ''], function () {

    Route::get('/profile', 'MainController@dashboard');


    Route::get('/', function () {
        return view('home');
    });

    Route::get('/home', function () {
        return view('general.home');
    });

    Route::get('/agency', 'MainController@agency');

    Route::get('/trades-services', function () {
        return view('general.trades-services');
    });

    Route::get('/customer', function () {
        return view('general.customer');
    });

    Route::get('/about', function () {
        return view('general.about');
    });


    Route::get('/reset-success', function () {
        return view('general.reset-successful');
    });

    Route::get('/register/agency/step-one', 'RegistrationController@Agency')->middleware('agency');

    Route::get('/register/agency/step-two', function () {

        return view('register.agency.step-two');
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

    Route::get('/register/customer/step-one', 'RegistrationController@Customer')->middleware('customer');

    Route::get('/register/customer/complete', 'RegistrationController@Review')->middleware('customer');

    Route::get('/dashboard/agency/profile', 'AgencyController@dashboard')->middleware('agency');

    Route::get('/dashboard/agency/edit', 'AgencyController@edit')->middleware('agency');
    Route::get('/dashboard/agency/settings', 'AgencyController@settings')->middleware('agency');

    Route::get('/dashboard/tradesman/profile', 'TradesmanController@dashboard')->middleware('tradesman');

    Route::get('/dashboard/tradesman/edit', 'TradesmanController@edit')->middleware('tradesman');

    Route::get('/dashboard/tradesman/settings', 'TradesmanController@settings')->middleware('tradesman');

    Route::get('/dashboard/customer/profile', 'CustomerController@dashboard')->middleware('customer');

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

    Route::get('/search-agency', function () {
        return view('general.search-agency');
    });


    Route::get('/savings-calculator', function () {
        return view('general.savings-calculator');
    });

    Route::get('/account-type', function () {
        return view('general.select-role');
    });


    Route::post('/register', 'RegistrationController@postRegister');

    Route::post('/login', 'LoginController@postLogin');

    Route::get('/login/{provider}', 'LoginController@redirectToProvider');

    Route::get('/login/{provider}/callback', 'LoginController@handleProviderCallback');

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

    Route::post('/agency-list', 'RegistrationController@listAgency');

    Route::post('/add-property', 'RegistrationController@addProperty');

    Route::post('/process-trades', 'CustomerController@spending');

    Route::post('/process-spending', 'CustomerController@updateAmount');

    Route::post('/upload-receipt', 'CustomerController@uploadReceipt');

    Route::post('/delete-transaction', 'CustomerController@delete');

    Route::post('/review', 'ReviewController@review');

    Route::post('/add-review', 'ReviewController@addReview');

    Route::post('/get-agent-info', 'CustomerController@agentInfo');

    Route::post('/retrieve-password', 'ForgotPasswordController@retrieve');

    Route::get('/reset/{email}/{resetCode}', 'ForgotPasswordController@resetPassword');

    Route::post('/reset/{email}/{resetCode}', 'ForgotPasswordController@reset');

    Route::get('/assign-role/{account}', 'LoginController@assignRole');

    Route::get('/activate/{email}/{activationCode}/{account}', 'ActivationController@activate');

    Route::get('/activation-sent', function () {
        return view('general.activation-sent');
    });

    Route::get('/verify/{provider}', 'LoginController@redirectToProvider');

    Route::get('/{action}/{provider}/callback', 'LoginController@verifyProviderCallback');

    Route::post('/search/{item}', 'SearchController@search');

    Route::get('/search/category/{category}/{suburb}', 'SearchController@tradesmenListing');

    Route::get('/profile/{role}/{id}', 'ProfileController@profile');

    Route::post('/helpful', 'ProfileController@helpful');

    Route::post('/send/{type}', 'SearchController@send');

    Route::get('/agency-listings', function () {
        return view('general.agency-listings');
    });

    Route::post('/order-business-card', 'TradesmanController@orderBC');

    Route::post('/contact-us', 'TradesmanController@contact');

    Route::group(['prefix' => 'admin'], function () {

        Route::get('', 'AdminController@showDashboard');
        Route::post('status/toggle', 'AdminController@toggleStatus');

        /*Route::get('dashboard', 'AdminController@showDashboard');

        Route::get('members', 'AdminController@showMembers');

        Route::get('properties', 'AdminController@showProperties');

        Route::get('reviews', 'AdminController@showReviews');

        Route::get('advertisements', 'AdminController@showAdvertisements');*/

        Route::get('login', 'AdminController@showLogin');

        Route::get('logout', 'AdminController@logout');

        Route::group(['prefix' => 'agency'], function () {

            Route::get('get', 'AgencyController@getAgency');

        });

        Route::group(['prefix' => 'property'], function () {

            Route::get('', 'PropertyController@getAllProperties');
            Route::get('get', 'PropertyController@getProperty');
            Route::post('delete', 'PropertyController@deleteProperty');
            Route::post('update', 'PropertyController@updateProperty');

        });

        Route::group(['prefix' => 'user'], function () {

            Route::get('', 'UserController@getAllUsers');
            Route::post('delete', 'UserController@deleteUser');

            Route::group(['prefix' => 'subscription'], function () {

                Route::post('extend', 'UserController@extendUserSubscription');

            });

        });

        Route::group(['prefix' => 'review'], function () {

            Route::get('', 'ReviewController@getAllReviews');
            Route::post('delete', 'ReviewController@deleteReview');

        });

        Route::group(['prefix' => 'category'], function () {

            Route::get('', 'CategoryController@getAllCategories');
            Route::post('delete', 'CategoryController@deleteCategory');

        });

        Route::group(['prefix' => 'suburb'], function () {

            Route::get('', 'SuburbController@getAllSuburbs');
            Route::post('delete', 'SuburbController@deleteSuburb');

            Route::group(['prefix' => 'agent'], function () {

                Route::get('', 'SuburbController@getSuburbAgents');
                Route::post('delete', 'SuburbController@deleteSuburbAgent');

            });

        });

    });

});

