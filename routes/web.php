<?php

use Illuminate\Support\Facades\Route;

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
Route::middleware(['throttle:60,1'])
->group(function(){
    Route::get('/', function () {
        return view('guest/index');
    });
    
    Auth::routes();
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::middleware(['auth', 'watched_ads'])
    ->prefix('res')
    ->group(function(){
        Route::get('/', function(){
            return view('home');
        }); 
    
        Route::get('/product/{id}/view', function(){
            return view('content.product-preview');
        });
    
        //Admin Routes
        Route::namespace('Admin')
        ->middleware('role:system administrator')
        ->group(function(){
            Route::resource('products', 'ProductsController')->middleware('can:access products');
            Route::resource('diamond/conversion/items', 'ItemsController')->middleware('can:access diamond conversion');
            Route::resource('diamond/conversion/request', 'DiamondConversionController')->middleware('can:access diamond conversion');
            Route::resource('dashboard', 'DashboardController')->middleware('can:access reports');
            Route::resource('users', 'UsersController')->middleware('can:access users');
            Route::resource('orders', 'OrdersController')->middleware('can:access products');
            Route::resource('sales', 'SalesController');
            Route::resource('fund-request', 'ManageFundsController');
        });
    
        //MemberRoutes
        Route::namespace('Member')
        ->group(function(){
            Route::resource('profile', 'DashboardController');
            Route::resource('manage-funds', 'ManageFundsController');
            Route::resource('network', 'NetworkController');
            Route::post('activate/account', 'SubscriptionController@activateAccount');
            Route::resource('diamond/conversion', 'DiamondConversionController');
            Route::get('login-bonus', 'DashboardController@loginBonus');
        });
    
        Route::namespace('Web')
        ->middleware('role:system administrator')
        ->group(function(){
            Route::get('wallet/update/{user_id}/{amount}', 'SubscriptionsController@addAmountOnWallet');
            Route::get('wallet/deduct/{user_id}/{amount}', 'SubscriptionsController@deductAmountOnWallet');
            Route::get('commission/update/{source}/{user_id}/{downline}/{amount}', 'SubscriptionsController@addCommissions');
        });
        Route::namespace('Web')->group(function(){
            Route::resource('subscriptions', 'SubscriptionsController');
        });
     
        Route::get('my-orders', 'Admin\OrdersController@userOrders');
        Route::resource('user/profile', 'User\ProfileController');
        Route::resource('logs/history', 'Member\LogsController');
        Route::resource('activity/logs', 'Admin\ActivityController');
        Route::resource('survey', 'Admin\SurveyController');
        Route::get('has/ads/{action}', 'Admin\SurveyController@watchAds');
        
    });
    
    Route::middleware('prevent_back_history')
    ->group(function(){
        Route::get('res/checkout/cart', 'Member\CartController@proceedToCheckout');
        Route::post('res/checkout/payment', 'Member\CartController@checkoutPayment');
        Route::get('res/validate/cashin', 'Member\ManageFundsController@validateRefence');
    });
    
    Route::resource('res/cart', 'Member\CartController');
    Route::get('res/order/invoice/{id}', 'Member\CartController@show');
    
    
    Route::namespace('Auth')
    ->group(function(){
        Route::post('retrive/account', 'ForgotPasswordController@retriveAccountUsingSecretQuestion');
        Route::post('verify/new/password', 'ForgotPasswordController@setNewPassword');
        Route::any('find/account', 'ForgotPasswordController@retriveAccount');
        Route::get('forget-password', 'ForgotPasswordController@forgetPasswordPage');
    });
    
    Route::get('confirm/account/{user}', 'Auth\RegisterController@verifyEmail');
    
    Route::middleware('auth')->namespace('Payment')->group(function(){
        Route::resource('payment', 'PaymentController')->middleware('prevent_back_history');
    });
    
    Route::namespace('API')->group(function(){
        // paymongo
        // pay using card
        Route::post('pay-with-card', 'PayMongoController@payWithCard');
    
        // pay using gcash/grab pay
        Route::post('/gcash-or-grabpay', 'PayMongoController@payWithGcashorGrabpay');
    
        // send gcash/grabpay payment
        Route::post('/check-wallet-status', 'PayMongoController@checkWalletStatus');
        Route::post('/send-gcash-grabpay-payment', 'PayMongoController@sendGcashOrGrabPayPayment');
    
        // get payment status
        Route::get('/get-payment-status', 'PayMongoController@getPaymentStatus');
    
        // cancel payment intent(card)
        Route::post('/cancel-payment-intent', 'PayMongoController@cancelPaymentIntent');
    
        // call once to create webhook
        Route::get('/webhook', 'PayMongoController@webhook');
    
        Route::post('pay-with-wallet', 'WalletController@payWithWallet');
    });    
});
// for cron jobs

// Route::namespace('Cron')
// ->group(function(){
//     Route::get('end/subscriptions', 'JobsController@endSubscription');
//     Route::get('recurring/earnings', 'JobsController@recurringEarnings');
// });