<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Role\RoleAndPermissionController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function(){
    Route::controller(AdminAuthController::class)->group(function(){
        Route::post('/forget-password','forgetPassword')->name('forget_password');
        Route::get('/reset-password','resetPasswordIndex')->name('reset_password');
        Route::post('/reset-password','resetPasswordUpdate')->name('reset_password');
    });
    Route::controller(AdminLoginController::class)->group(function(){
        Route::get('/login','login')->name('login');
        Route::post('/login','handleLogin')->name('login');
        Route::get('/logout','handleLogout')->name('logout');
        Route::get('/dashboard','index')->name('index')->middleware('admin','adminStatusCheck');
    });

    Route::middleware('admin','adminStatusCheck')->group(function(){
        //user routes
        Route::resource('user',UserController::class);
        Route::controller(UserController::class)->name('user.')->prefix('user')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus')->name('user_status');
        });

        //roles and permissions
        Route::resource('role',RoleAndPermissionController::class);
    });
});
