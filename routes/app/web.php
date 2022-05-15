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
        // Route::get('category', [CategoryC::class, 'index'])->name('category.index');
        // Route::get('category/{category:slug}', [CategoryC::class, 'show'])->name('category.show');
        // Route::get('about', [WebC::class, 'about'])->name('about');
        // Route::get('product', [ProductC::class, 'index'])->name('product.index');
        // Route::get('product/{product:slug}', [ProductC::class, 'show'])->name('product.show');
        Route::get('auth',[AuthController::class, 'index'])->name('auth.index');
        Route::prefix('auth/')->name('auth.')->group(function(){
            Route::post('login',[AuthController::class, 'do_login'])->name('login');
            Route::post('register',[AuthController::class, 'do_register'])->name('register');
        });
        Route::resource('product', ProductController::class);
        // Route::get('province/list',[ProvinceController::class, 'list'])->name('province.get');
        // Route::get('city/list',[CityController::class, 'list'])->name('city.get');
        // Route::get('subdistrict/list',[SubdistrictController::class, 'list'])->name('subdistrict.get');
        // Route::get('order/ongkir',[OrderC::class, 'ongkir'])->name('ongkir.get');
        // Route::post('city/get_list',[CityController::class, 'get_list'])->name('city.get_list');
        // Route::post('subdistrict/get_list',[SubdistrictController::class, 'get_list'])->name('subdistrict.get_list');    
        
        Route::middleware(['auth'])->group(function(){
        //     Route::get('profile',[AuthController::class, 'profile'])->name('auth.profile');
        //     Route::get('profile/{user:id}/edit',[AuthController::class, 'edit_profile'])->name('auth.edit');
        //     Route::post('profile/{user}/update',[AuthController::class, 'update_profile'])->name('auth.update');
                Route::get('checkout/create/{product}', [CheckoutController::class, 'create'])->name('checkout.create');
                Route::get('logout',[AuthController::class, 'do_logout'])->name('auth.logout');
                Route::post('checkout/add', [CheckoutController::class, 'add'])->name('checkout.add');
                Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout.store');
                Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        //     Route::post('checkout/store', [OrderC::class, 'store'])->name('checkout.store');
        //     Route::patch('order/{order}/cancel', [OrderC::class, 'cancel'])->name('order.cancel');
        //     Route::patch('order/{order}/receive', [OrderC::class, 'receive'])->name('order.receive');
        //     Route::post('order/{order}/review', [OrderC::class, 'review'])->name('order.review');
        //     Route::post('order/{order}/doreview', [OrderC::class, 'do_review'])->name('order.do_review');
        //     Route::get('order/{order}/pdf', [OrderC::class, 'pdf'])->name('order.pdf');
        //     Route::get('cart/list', [CartC::class, 'list'])->name('cart.list');
        //     Route::delete('cart/{cart}/delete', [CartC::class, 'destroy'])->name('cart.destroy');
        //     Route::post('cart/store', [CartC::class, 'store'])->name('cart.store');
        });

        // Route::group(['middleware' => ['auth:web','verified']], function () {
            
        // });
    });
});