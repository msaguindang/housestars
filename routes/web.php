<?php
use App\UserMeta;
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

Route::group(['prefix' => ''], function(){


    Route::get('/profile', 'MainController@dashboard');


    Route::get('/', 'MainController@home');

    // Route::get('/', function () {
    //     return view('home');
    // })->name('homepage');


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

    Route::get('/register/agency/step-one', 'RegistrationController@Agency');

    Route::get('/register/agency/step-two', function () {
        return view('register.agency.step-two');
    });

    Route::get('/register/agency/step-three', 'RegistrationController@Payment');

    Route::get('/register/agency/step-four', 'RegistrationController@Review')->middleware('agency');

    Route::get('/register/agency/complete', function () {
        return view('register.agency.complete');
    })->middleware('agency');

    Route::get('/register/tradesman/step-one', 'RegistrationController@Tradesman');

    Route::get('/register/tradesman/step-two', 'RegistrationController@Payment');

    Route::get('/register/tradesman/step-three', 'RegistrationController@Review')->middleware('tradesman');

    Route::get('/register/tradesman/complete', function () {
        return view('register.tradesman.complete');
    })->middleware('tradesman');

    Route::get('/register/customer/step-one', 'RegistrationController@Customer')->middleware('customer');

    Route::get('/register/customer/complete', 'RegistrationController@Review')->middleware('customer');

    Route::get('/dashboard/agency/profile', 'AgencyController@dashboard')->middleware('agency');

    Route::get('/dashboard/agency/edit', 'AgencyController@edit')->middleware('agency');

     Route::get('/dashboard/agent/profile', 'AgentController@dashboard')->middleware('agent');

    Route::get('/dashboard/agent/edit', 'AgentController@edit')->middleware('agent');

    Route::get('/dashboard/agency/settings', 'AgencyController@settings')->middleware('agency');

    Route::get('/dashboard/agent/settings', 'AgentController@settings')->middleware('agent');

    Route::get('/dashboard/tradesman/profile', 'TradesmanController@dashboard')->middleware('tradesman');

    Route::get('/dashboard/tradesman/edit', 'TradesmanController@edit')->middleware('tradesman');

    Route::get('/dashboard/tradesman/settings', 'TradesmanController@settings')->middleware('tradesman');

    Route::get('/dashboard/customer/profile', 'CustomerController@dashboard')->middleware('customer');

    Route::get('/dashboard/customer/edit', 'CustomerController@edit')->middleware('customer');

    Route::get('/dashboard/customer/add', 'CustomerController@property')->middleware('customer');

    Route::post('/dashboard/customer/add-property', 'CustomerController@addProperty')->middleware('customer');

    Route::get('/search-category', function () {
        return view('general.search-category');
    });

    Route::get('/payment-status', 'MainController@unpaid');

    Route::get('/home-error', function () {
        return view('social-login');
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

    Route::post('/update-profile-agent', 'AgentController@updateProfile');

    Route::post('/update-settings', 'AgencyController@updateSettings');

    Route::post('/update-payment', 'AgencyController@updatePayment');

    Route::post('/delete-agent', 'AgencyController@deleteAgent');

    Route::post('/update-agents', 'AgencyController@updateAgent');

    Route::post('upload', 'TradesmanController@upload');

    Route::post('tradesman/update-profile', 'TradesmanController@updateProfile');

    Route::post('tradesman/validate-suburb-availability', 'TradesmanController@validateSuburbAvailability');

    Route::post('tradesman/validate-availability', 'TradesmanController@validateAvailability');

    Route::get('tradesman/search-suburb', 'TradesmanController@searchSuburb');

    Route::post('/register', 'RegistrationController@postRegister');

    Route::post('/delete-item', 'TradesmanController@deleteItem');

    Route::post('/agency-list', 'RegistrationController@listAgency');

    Route::post('/add-property', 'RegistrationController@addProperty');

    Route::get('/login/{provider}/callback/', 'LoginController@handleProviderCallback');

    Route::post('/process-trades', 'CustomerController@spending');

    Route::post('/process-spending', 'CustomerController@updateAmount');

    Route::post('/upload-receipt', 'CustomerController@uploadReceipt');

    Route::post('/delete-transaction', 'CustomerController@delete');

    Route::post('/upload-contract', 'CustomerController@uploadContract');

    Route::post('/confirm', 'CustomerController@confirm');

    Route::post('/process-form', 'CustomerController@processForm');

    Route::post('/delete-transaction', 'CustomerController@delete');

    // Route::post('/review', 'ReviewController@review');

    // Route::post('/add-review', 'ReviewController@addAReview');

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

    Route::post('/savings-calculator', 'MainController@savingsCalculator');

    Route::post('/customer/update-settings', 'CustomerController@update');

    Route::get('admin/login', 'AdminController@showLogin');
    Route::post('admin/login', 'AdminController@postLogin');

    Route::get('/verify/{provider}', 'LoginController@verifyToProvider');
    Route::get('/reviewer','LoginController@chooseBusiness');
    Route::get('/choose-business', function() {
        return view('choose_business');
    });
    Route::post('/review', 'ReviewController@addAReview');
    Route::post('/create/review', 'ReviewController@create');

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

        Route::get('', 'AdminController@showDashboard');
        Route::post('status/toggle', 'AdminController@toggleStatus');

        Route::get('logout', 'AdminController@logout');

        Route::group(['prefix' => 'agency'], function () {

            Route::get('get', 'AgencyController@getAgency');

        });

        Route::group(['prefix' => 'property'], function () {

            Route::get('', 'PropertyController@getAllProperties');
            Route::get('get', 'PropertyController@getProperty');
            Route::post('delete', 'PropertyController@deleteProperty');
            Route::post('update', 'PropertyController@updateProperty');

            Route::post('property-process/update', 'PropertyController@updatePropertyProcessStatus');

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

        Route::group(['prefix' => 'advertisement'], function () {

            Route::get('', 'AdvertisementController@getAllAdvertisements');
            Route::get('get', 'AdvertisementController@getAdvertisement');
            Route::post('insert', 'AdvertisementController@insertAdvertisement');
            Route::post('update', 'AdvertisementController@updateAdvertisement');
            Route::post('delete', 'AdvertisementController@deleteAdvertisement');

        });

        Route::group(['prefix' => 'category'], function () {

            Route::get('', 'CategoryController@getAllCategories');
            Route::post('delete', 'CategoryController@deleteCategory');
            Route::post('insert', 'CategoryController@insertCategory');
            Route::post('update', 'CategoryController@updateCategory');

        });

        Route::group(['prefix' => 'suburb'], function () {

            Route::get('', 'SuburbController@getAllSuburbs');
            Route::post('delete', 'SuburbController@deleteSuburb');
            Route::post('availability/update', 'SuburbController@updateSuburbAvailability');

            Route::group(['prefix' => 'agent'], function () {

                Route::get('', 'SuburbController@getSuburbAgents');
                Route::post('delete', 'SuburbController@deleteSuburbAgent');

            });

        });

    });

});

// ===================================================================================================================================================
// NEW ROUTES
// ===================================================================================================================================================
Route::post('create/potential-customer', 'MainController@createPotentialCustomer');

// ===================================================================================================================================================
