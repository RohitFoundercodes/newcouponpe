<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AuthApiController,PublicApiController,ONDCApiController,PaymentController};
use Illuminate\Session\Middleware\StartSession;

 Route::get('/payin-successfully',[PaymentController::class,'redirect_success'])->name('payin.successfully');
 
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');



// AuthController 
    Route::controller(AuthApiController::class)->group(function () {
        Route::Post('/getOtp', 'GetOtp');
        Route::Post('/login', 'Login');
        Route::Post('/loginwithemail', 'Loginwithemail');
        Route::Post('/register', 'Register');
        Route::get('/logout', 'Logout')->middleware('auth:sanctum');
    });
    
// ProfileController

    Route::middleware('throttle:100,1')->group(function () {

        Route::group(['middleware'=>'auth:sanctum'],function(){

    
        Route::controller(PublicApiController::class)->group(function () {
            Route::post('/userProfile', 'UserProfile');
            Route::post('/user/profileUpdate', 'UserProfileUpdate');
            Route::get('/banner','Banners');
            Route::get('/siteContent/{id}','SiteContents');
            Route::post('/notification', 'Notifications');
            Route::post('/notification-delete', 'NotificationDelete');
            Route::post('/referral', 'Referral');
            });
            
        Route::controller(ONDCApiController::class)->group(function () {
            Route::get('/catalogue', 'ListCatalogue');
     

            });
            
            
         
          
        });
    });
    
    Route::controller(ONDCApiController::class)->group(function () {
            // Route::get('/catalogue', 'ListCatalogue');
            Route::get('/catalogue', 'fetchCatalogue');
            Route::get('/catalogue/search', 'SearchCatalogues');
            Route::get('/catalogue/{id}', 'ReadSingleCatalogueItem');
            Route::get('/company_order/getQuote', 'GetQuote');
            Route::post('/company_order/RealyforOrder/{action}', 'RealyGetQuote');
            Route::post('/company_order/place-order', 'PlaceOrder');
            Route::get('/company_order/OrderStatus/{companyOrderId}/{transactionId}', 'OrderStatus');
             Route::get('/company_order/OrderHistory/{userid}', 'orderhistory');

            });
            
            
            Route::controller(PaymentController::class)->group(function () {
            // Route::get('/catalogue', 'ListCatalogue');
                Route::post('/payin', 'Payin');
                Route::get('/checkPayment','checkPayment');
               
            

            });
            
            
        Route::controller(PublicApiController::class)->group(function () {
            Route::post('/payinHistory', 'PayinHistory');
   
            });
           
    
