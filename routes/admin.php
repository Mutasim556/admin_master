<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Localization\BackendLanguageController;
use App\Http\Controllers\Admin\Localization\ChangeLanguageController;
use App\Http\Controllers\Admin\Localization\LanguageController;
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
        Route::get('/admin-profile','adminProfile')->name('profile')->middleware('admin','adminStatusCheck');
        Route::post('/update-basic-info','updateBasicInfo')->name('basicInfo')->middleware('admin','adminStatusCheck');
        Route::post('/update-password','updatePassword')->name('update_basic_info')->middleware('admin','adminStatusCheck');
    });

    Route::middleware('admin','adminStatusCheck')->group(function(){
        //user routes
        Route::resource('user',UserController::class)->except(['craete','show']);
        Route::controller(UserController::class)->name('user.')->prefix('user')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus')->name('user_status');
        });

        //roles and permissions
        Route::resource('role',RoleAndPermissionController::class)->except(['craete','show']);

        //language controller 
        Route::resource('language',LanguageController::class)->except(['craete','show']);
        Route::controller(LanguageController::class)->name('language.')->prefix('language')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus')->name('language_status');
        });

        //backend language controller 
        Route::resource('backend/language',BackendLanguageController::class,['as'=>'backend'])->except(['craete','show','edit','distroy']);
        Route::controller(BackendLanguageController::class)->name('backend.language.')->prefix('backend/language')->group(function () {
            Route::post('/store/translate/string', 'storeTranslateString')->name('storeTranslateString');
            Route::post('/store/apikey', 'storeApikey')->name('storeApikey');
        });
        Route::get('/change/language/{lang}',ChangeLanguageController::class)->name('changeLanguage');
    });
});
