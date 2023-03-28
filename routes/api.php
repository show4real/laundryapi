<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\AdminVendorController;
use App\Http\Controllers\Api\PaymentHistoryController;

use App\Http\Controllers\Api\VendorProductController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\SubscriptionController;

use App\Http\Controllers\Api\VendorProfileController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DriverAuthController;

use App\Http\Controllers\Api\ForgotPasswordController;



// use App\Http\Controllers\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



 
Route::post('login', [LoginController::class, 'login']);
Route::post('vendor_register', [RegisterController::class, 'vendorRegister']);

Route::post('addorder', [CustomerController::class, 'addOrder']);

Route::get('recoverpassword/{recovery_code}', [ForgotPasswordController::class, 'recover']);
Route::post('resetpassword', [ForgotPasswordController::class, 'changepassword']);
Route::post('sendrecovery', [ForgotPasswordController::class, 'sendrecovery']);










Route::group(['middleware' => ['jwt.auth', 'CheckAdmin'], 'prefix' => 'admin'],
    function () {
      
        Route::controller(UserController::class)->group(function () {
            Route::post('users', 'index');
            Route::post('adduser', 'save');
            Route::post('updateuser/{user}', 'update');
            Route::get('user/{user}', 'show');
            Route::post('deleteuser/{id}', 'delete');
        });

        Route::controller(AdminVendorController::class)->group(function () {
            Route::post('vendors', 'index');
            Route::post('addvendor', 'save');
            Route::post('vendoruser/{vendor}', 'update');
            Route::get('vendor/{vendor}', 'show');
            Route::post('vendor/delete/{id}', 'delete');
        });

         Route::controller(OrderController::class)->group(function () {
           
            Route::post('orders', 'adminOrders');
             Route::post('updateorder', 'updateOrder');
        });

         Route::controller(CategoryController::class)->group(function () {
            Route::post('categories', 'index');
            Route::post('addcategory', 'save');
            Route::post('updatecategory/{category}', 'update');
            Route::get('category/{category}', 'show');
            Route::post('deletecategory/{id}', 'delete');
        });

        Route::controller(SubscriptionController::class)->group(function () {
            Route::post('subscriptions', 'index');
            Route::post('addsubscription', 'save');
            Route::post('updatesubscription/{subscription}', 'update');
            Route::get('subscription/{subscription}', 'show');
            Route::post('deletesubscription/{id}', 'delete');
        });

        Route::controller(ServiceController::class)->group(function () {
            Route::post('services', 'index');
            Route::post('addservice', 'save');
            Route::post('updateservice/{service}', 'update');
            Route::get('service/{service}', 'show');
            Route::post('deleteservice/{id}', 'delete');
        });

         Route::controller(ProductController::class)->group(function () {
            Route::post('products', 'index');
            Route::post('addproduct', 'save');
            Route::post('updateproduct/{product}', 'update');
            Route::get('product/{product}', 'show');
            Route::post('deleteproduct/{id}', 'delete');
        });

         Route::controller(DriverController::class)->group(function () {
            Route::post('drivers', 'index2');
            Route::get('driver/{driver}', 'show');
            Route::post('deletedriver/{id}', 'delete');
        });

         Route::controller(PaymentHistoryController::class)->group(function () {
            Route::post('payments', 'adminIndex');
            Route::post('updatepayment/{payment}', 'adminUpdate');
        });


    }
);

Route::group(['middleware' => ['jwt.auth', 'CheckVendor'], 'prefix' => 'vendor'],
    function () {
     
        Route::controller(VendorController::class)->group(function () {
           
            Route::post('save', 'save');
            Route::get('profile', 'vendor');

        });

         Route::controller(OrderController::class)->group(function () {
           
            Route::post('orders', 'vendorOrders');
              Route::post('updateorder', 'updateOrder');
        });

         Route::controller(PaymentHistoryController::class)->group(function () {
            Route::post('payments', 'index');
            Route::post('addpayment', 'save');
            Route::post('updatepayment/{payment}', 'update');
            Route::post('deletepayment/{id}', 'delete');
        });

         Route::controller(CategoryController::class)->group(function () {
            Route::post('categories', 'index');
            Route::get('category/{category}', 'show');
        });

        Route::controller(ServiceController::class)->group(function () {
            Route::post('services', 'index');
            Route::get('service/{service}', 'show');
        });

         Route::controller(VendorProductController::class)->group(function () {
            Route::post('products', 'index');
            Route::post('addproduct', 'save');
            Route::post('updateproduct/{product}', 'update');
            Route::get('product/{product}', 'show');
            Route::post('deleteproduct/{id}', 'delete');
        });

        Route::controller(DriverController::class)->group(function () {
            Route::post('drivers', 'index');
            Route::post('adddriver', 'save');
            Route::post('updatedriver/{driver}', 'update');
            Route::get('driver/{driver}', 'show');
            Route::post('deletedriver/{id}', 'delete');
        });

         Route::controller(VendorProfileController::class)->group(function () {
            Route::get('profile', 'profile');

            Route::post('addprofile', 'update');
            Route::post('addimage', 'editImage');
        });


    }
);


Route::group(['middleware' => ['jwt.auth', 'CheckDriver'], 'prefix' => 'driver'],
    function () {
     
        Route::controller(OrderController::class)->group(function () {
           
            Route::post('orders', 'driverOrders');
            Route::post('queued/orders', 'queuedOrders');
            Route::post('accept/order', 'acceptOrder');
            Route::post('complete/order', 'completeOrder');
            Route::post('cancel/order', 'cancelOrder');
        });

        Route::controller(DriverAuthController::class)->group(function () {
           
            Route::get('profile', 'profile');
            Route::post('update/profile', 'update');
        });

        

    }
);




