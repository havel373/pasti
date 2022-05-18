<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Office\AuthController;
use App\Http\Controllers\Office\DashboardController;
use App\Http\Controllers\Office\OrderController;
use App\Http\Controllers\Office\CustomerController;
use App\Http\Controllers\Office\GalleryController;
use App\Http\Controllers\Office\ProductController;
use App\Providers\RouteServiceProvider as ProvidersRouteServiceProvider;

Route::group(['domain' => ''], function() {
    Route::prefix('office/')->name('office.')->group(function(){
        Route::get('auth',[AuthController::class, 'index'])->name('auth.index');
        Route::prefix('auth')->name('auth.')->group(function(){
            Route::post('login',[AuthController::class, 'do_login'])->name('login');
            Route::post('register',[AuthController::class, 'do_register'])->name('register');
        });

        Route::middleware(['auth'])->group(function(){
            Route::get('logout',[AuthController::class, 'do_logout'])->name('auth.logout');
        }); 

        Route::group(['middleware' => ['auth']], function () {
            Route::redirect('/', ProvidersRouteServiceProvider::DASHBOARD, 301);
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('banner', GalleryController::class);
            Route::resource('product', ProductController::class);
            Route::resource('user', CustomerController::class);
            Route::resource('order', OrderController::class);
            Route::get('order/{order}/download', [OrderController::class, 'download'])->name('order.download');
            Route::patch('order/{order}/reject', [OrderController::class, 'reject'])->name('order.reject');
            Route::patch('order/{order}/acc', [OrderController::class, 'acc'])->name('order.acc');
        });
    });
});
