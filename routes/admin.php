<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function(){
    Route::controller(AdminLoginController::class)->group(function(){
        Route::get('/login','login')->name('login');
        Route::post('/login','handleLogin')->name('login');
        Route::get('/logout','handleLogout')->name('logout');
        Route::get('/dashboard','index')->name('index')->middleware('admin');
    });

    //user routes
    Route::resource('user',UserController::class);
});
