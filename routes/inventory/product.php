<?php

use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\ParentCategoryController;
use App\Http\Controllers\Admin\Product\SizeController;
use App\Http\Controllers\Admin\Product\UnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->name('product.')->group(function(){

   //units
   Route::resource('unit',UnitController::class)->except('create','show');
   Route::controller(UnitController::class)->prefix('unit')->group(function(){
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });

   //brands
   Route::resource('brand',BrandController::class)->except('create','show');
   Route::controller(BrandController::class)->prefix('brand')->group(function(){
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });

   //size
   Route::resource('size',SizeController::class)->except('create','show');
   Route::controller(SizeController::class)->prefix('size')->group(function(){
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });

   //parent category
   Route::resource('parent-category',ParentCategoryController::class)->except('create','show');
   Route::controller(ParentCategoryController::class)->prefix('parent-category')->group(function(){
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });
});