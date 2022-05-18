<?php

use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\WebController;
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

Route::group(['domain' => ''], function() {
    Route::prefix('')->name('web.')->group(function(){
        Route::redirect('/', 'home', 301);
        Route::get('account/verify/{token}', [AuthController::class, 'verify'])->name('verify'); 
        Route::get('home', [WebController::class, 'index'])->name('home');
        Route::get('about', [WebController::class, 'about'])->name('about');
        Route::get('auth',[AuthController::class, 'index'])->name('auth.index');
        Route::prefix('auth/')->name('auth.')->group(function(){
            Route::post('login',[AuthController::class, 'do_login'])->name('login');
            Route::post('register',[AuthController::class, 'do_register'])->name('register');
        });
        Route::resource('product', ProductController::class);
        Route::group(['middleware' => ['auth']], function () {
                Route::get('checkout/create/{product}', [CheckoutController::class, 'create'])->name('checkout.create');
                Route::get('logout',[AuthController::class, 'do_logout'])->name('auth.logout');
                Route::post('checkout/add', [CheckoutController::class, 'add'])->name('checkout.add');
                Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout.store');
                Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        });
    });
});