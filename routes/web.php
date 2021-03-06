<?php

use App\UserMeta;
use App\Video;
use Illuminate\Http\Request;
use App\Services\ReviewService;

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


Route::get('testing-page', 'MainController@test');

Route::group(['prefix' => ''], function () {

    Route::get('/profile', 'MainController@dashboard');

    Route::get('/', [
        'as'    => 'homepage',
        'uses'  => 'MainController@home'
    ]);

    Route::get('/terms-and-conditions', [
        'as' => 'terms.and.conditions',
        function () {
            return view('general.terms-and-conditions');
        }
    ]);


    Route::get('/privacy-policy', function () {
        return view('general.privacy-policy');
    });

    Route::post('/delete-gallery-photo', [
        'as' => 'delete.gallery.photo',
        function (Request $request) {
            $galleryService = app()->make(App\Services\GalleryService::class);
            return $galleryService->delete($request->all());
        }
    ]);

    Route::get('/verify-customer/{email}', [
       'as'   => 'verify_potential_customer',
       'uses' => 'ActivationController@verifiedPotentialCustomer'
    ]);

    Route::get('/home', function () {
        return view('general.home');
    });

    Route::get('/our-agent-philosophy', function () {
        return view('general.agent-philosophy');
    });

    Route::get('/our-service-philosophy', function () {
        return view('general.service-philosophy');
    });

    Route::get('/guidelines', function () {
        return view('general.guidelines');
    });

    Route::get('/process-page', function () {
        return view('general.process');
    });

    Route::post('/verify-user-to-rate', [
        'as'   => 'verify_to_rate',
        'uses' => 'MainController@verifyPotentialUser'
    ]);

    Route::get('/about-us', function () {
        return view('general.about-us');
    });

    Route::get('/agency', 'MainController@agency');

    Route::get('/trades-services', function () {
        $data = [];
        if($video = Video::active('trade-services')->first()) {
            $data['video'] = $video->url . '?autoplay=1&rel=0';
        }
        return view('general.trades-services')->with('data', $data);
    });

    Route::get('/customer', function () {
        $data = [];
        if($video = Video::active('customer')->first()) {
            $data['video'] = $video->url . '?autoplay=1&rel=0';
        }
        return view('general.customer')->with('data', $data);
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

    Route::get('/register/customer/step-one', 'RegistrationController@Customer');

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

    Route::post('/validate-abn', 'MainController@validateABN');

    Route::get('/payment-status', 'MainController@unpaid');

    Route::get('/home-error', function () {
        return view('social-login');
    });

    Route::get('/category-listings', function () {
        return view('general.category-listings');
    });

    Route::get('/tradesman-listings', function () {
        return view('general.tradesman-listings')->with('data', []);
    });

    Route::get('/search-agency', function () {
        return view('general.search-agency');
    });

    Route::post('/search-agency', [
        'as'    => 'post_search_agency',
        'uses'  => 'SearchController@postSearchAgency'
    ]);

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
    
    Route::post('/agency/add-position', 'RegistrationController@postPosition');

    Route::post('/add-agents', 'RegistrationController@postAddAgents');

    Route::post('/add-payment', 'RegistrationController@postPayment');

    Route::post('/charge', 'RegistrationController@postCharge');

    Route::post('/update-profile-agent', 'AgentController@updateProfile');
    Route::post('/update-profile', 'AgencyController@updateProfile');

    Route::post('/update-profile-agent/{id}', 'AgentController@updateProfile');
    Route::post('/update-profile/{id}', 'AgencyController@updateProfile');

    Route::post('/update-settings', 'AgencyController@updateSettings');

    Route::post('/update-payment', 'AgencyController@updatePayment');

    Route::post('/delete-agent', 'AgencyController@deleteAgent');

    Route::post('/update-agents', 'AgencyController@updateAgent');

    Route::post('upload/{id?}', 'TradesmanController@upload');

    Route::post('tradesman/update-profile', 'TradesmanController@updateProfile');
    Route::post('tradesman/update-profile/{id}', 'TradesmanController@updateProfile');

    Route::post('tradesman/validate-suburb-availability', 'TradesmanController@validateSuburbAvailability');

    Route::post('tradesman/validate-availability', 'TradesmanController@validateAvailability');

    Route::get('tradesman/search-suburb', 'TradesmanController@searchSuburb');

    Route::post('agency/validate-suburb-availability', 'AgencyController@validateSuburbAvailability');

    Route::post('agency/validate-availability', 'AgencyController@validateAvailability');

    Route::get('agency/search-suburb', 'AgencyController@searchSuburb');

    Route::get('/search-agency', 'SearchController@showResults');

    Route::post('/register', 'RegistrationController@postRegister');

    Route::post('/delete-item', 'TradesmanController@deleteItem');

    Route::post('/agency-list', 'RegistrationController@listAgency');


    Route::post('/add-property', 'RegistrationController@addProperty');

    Route::get('/login/{provider}/callback/', 'LoginController@handleProviderCallback');

    Route::post('/process-trades', 'CustomerController@spending');

    Route::post('/process-spending', 'CustomerController@updateAmount');

      Route::post('/update-commission', 'CustomerController@updateCommission');

    Route::post('/upload-receipt', 'CustomerController@uploadReceipt');

    Route::post('/delete-transaction', 'CustomerController@delete');

    Route::post('/upload-contract', 'CustomerController@uploadContract');

    Route::post('/confirm', 'CustomerController@confirm');

    Route::post('/process-form', 'CustomerController@processForm');

    Route::post('/delete-transaction', 'CustomerController@delete');

    Route::post('/review-vendor', 'ReviewController@review');

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

    Route::get('/listing/{category}/{suburb}', 'SearchController@tradesmenListing');

    Route::post('/search/{item}', [
        'as'   => 'search.item',
        'uses' => 'SearchController@search'
    ]);

    Route::get('/profile/customer/{id}', 'CustomerController@dashboard');
    
    Route::get('/profile/{role}/{id}',[
        'as'   => 'profile.role.id',
        'uses' => 'ProfileController@profile'
    ]);
    
    Route::get('/profile/{role}/{id}/edit',[
        'as'   => 'profile.role.id.edit',
        'uses' => 'ProfileController@editProfile'
    ]);

    Route::get('/public-profile/{id}', 'ProfileController@getPublicProfile');

    Route::post('/helpful', 'ProfileController@helpful');

    Route::post('/send/{type}', 'SearchController@send');

    Route::get('/agency-listings', function () {
        return view('general.agency-listings');
    });

    Route::post('/order-business-card', 'TradesmanController@orderBC');

    Route::post('/contact-us', 'MainController@contact');

    Route::post('/customer/update-settings/{id}', 'CustomerController@update');

    Route::get('admin/login', 'AdminController@showLogin');
    Route::post('admin/login', 'AdminController@postLogin');

    Route::post('/referral', 'TradesmanController@referral');

    Route::get('/verify/{provider}', 'LoginController@verifyToProvider');

    Route::get('/verify/{provider}/review/{role}/{businessId}', [
        'as'   => 'verify.provider.review.business',
        'uses' => 'LoginController@verifyToProviderToReviewBusiness'
    ]);

    Route::get('/reviewer', 'LoginController@chooseBusiness');

    Route::get('/choose-business', function (Request $request) {
        if (session()->exists('business') && session()->exists('role')) {
            $role = session()->get('role');
            $ip = $request->ip();
            $businessId = session()->get('business');
            $redirect = "/profile/$role/$businessId";
            $businessInfo = app(ReviewService::class)->validateBusinessReview($ip, $businessId, $redirect);
            
            return redirect($redirect)->with(['show_rate' => true, 'businessInfo' => $businessInfo]);
        } else if (session()->exists('email')) {
            return view('choose_business');
        }
        return redirect('/');
    });

    

    Route::post('/create/potential-customer', 'PotentialCustomerController@store');

    Route::get('/verify/{provider}/agency/{id}', 'LoginController@verifyToProviderAgency');
    Route::post('/review-agency/create/review', 'ReviewController@create');
    Route::get('/review/business/{id}', 'ReviewController@reviewBusiness');

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

        Route::get('test', 'AdminController@test');
        Route::get('/',[
            'as'   => 'admin.index',
            'uses' => 'AdminController@showDashboard'
        ]);
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
            Route::post('insert', 'UserController@createUser');
            Route::post('update', 'UserController@updateUser');
            Route::get('export', 'UserController@exportUsers');
            Route::get('count-by-role', 'UserController@getTotalCountByRole');
            Route::get('total-billed', 'UserController@getTotalBilledPayment');

            Route::group(['prefix' => 'subscription'], function () {
                Route::post('extend', 'UserController@extendUserSubscription');
            });

            Route::get('role', 'UserController@getAllRoles');
            Route::get('mailing-list', 'UserController@getUsersMailingList');
        });

        Route::group(['prefix' => 'review'], function () {

            Route::get('', 'ReviewController@getAllReviews');
            Route::post('/delete', 'ReviewController@deleteReview');
            Route::get('/filter', 'ReviewController@getReviewsByFilter');
            Route::get('/search', 'ReviewController@searchReviews');

            Route::group(['prefix' => 'reviewees'], function () {

                Route::get('', 'ReviewController@getAllReviewees');

            });

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
            Route::post('save-max-tradie', 'SuburbController@saveMaxTradie');

            Route::group(['prefix' => 'agent'], function () {

                Route::get('', 'SuburbController@getSuburbAgents');
                Route::post('delete', 'SuburbController@deleteSuburbAgent');

            });

        });

        Route::group(['prefix' => 'potential-customer'], function () {

            Route::get('', 'PotentialCustomerController@getAllPotentialCustomers');
            Route::post('delete', 'PotentialCustomerController@deletePotentialCustomer');
            Route::get('export', 'PotentialCustomerController@exportPotentialCustomers');

        });

        Route::group(['prefix' => 'videos'], function () {
            Route::get('/', 'VideoController@getAllVideos');
            Route::post('/delete', 'VideoController@deleteVideo');
            Route::post('/save', 'VideoController@saveVideo');
        });

        Route::group(['prefix' => 'report'], function () {

            Route::get('tradesman/earnings', 'ReportController@getTradesmanEarningsReport');
            Route::get('transaction/years', 'ReportController@getAllTransactionYears');
            Route::get('transaction/total', 'ReportController@getTotalTransactions');
            Route::get('avg-agent-commission', 'ReportController@getAverageAgentCommission');

        });

    });

    Route::group(['prefix' => 'faq'], function () {

        Route::get('customer', 'FaqController@customer');
        Route::get('agency', 'FaqController@agency');
        Route::get('tradesman', 'FaqController@tradesman');

    });

    Route::group(['middleware' => 'web'], function() {
        Route::post('/review', 'ReviewController@addAReview');
        Route::post('/create/review', 'ReviewController@create');
    });


Route::group(['prefix' => 'legal'], function () {

        Route::get('terms-conditions', 'MainController@termsConditions');
        Route::get('privacy-policy', 'MainController@privacyPolicy');

    });




});

// ===================================================================================================================================================
// NEW ROUTES
// ===================================================================================================================================================

// ===================================================================================================================================================
