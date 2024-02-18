<?php

use App\Http\Controllers\Admin\Product\AdjustmentController;
use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\ParentCategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\SizeController;
use App\Http\Controllers\Admin\Product\UnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->name('product.')->group(function () {

   //units
   Route::resource('unit', UnitController::class)->except('create', 'show');
   Route::controller(UnitController::class)->prefix('unit')->group(function () {
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });

   //brands
   Route::resource('brand', BrandController::class)->except('create', 'show');
   Route::controller(BrandController::class)->prefix('brand')->group(function () {
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });

   //size
   Route::resource('size', SizeController::class)->except('create', 'show');
   Route::controller(SizeController::class)->prefix('size')->group(function () {
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });

   //parent category
   Route::resource('parent-category', ParentCategoryController::class)->except('create', 'show');
   Route::controller(ParentCategoryController::class)->prefix('parent-category')->group(function () {
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });

   //category
   Route::resource('category', CategoryController::class)->except('create', 'show');
   Route::controller(CategoryController::class)->prefix('category')->group(function () {
      Route::get('/update/status/{id}/{status}', 'updateStatus');
   });
});
//product
Route::resource('product', ProductController::class);
Route::controller(ProductController::class)->prefix('product')->group(function () {
   Route::get('/update/status/{id}/{status}', 'updateStatus');
   Route::get('/generate/product-code', 'generateProductCode');
   Route::get('/get-unit/{pram}', 'getUnit');
   Route::get('/get-variant/{pram}', 'getVariant');
   Route::get('/print/barcode', 'printBarcode')->name('product.printBarcode');
   Route::post('/generate/barcode', 'generateBarcode')->name('product.generateBarcode');
});
Route::resource('productAdjustment', AdjustmentController::class)->except('show','edit','update','destroy');
Route::controller(AdjustmentController::class)->prefix('product')->group(function () {
   Route::get('/warehouse/product/{id}', 'getWarehouseProduct')->name('product.getWarehouseProduct');
   Route::get('/get/product/{id}/{wid}', 'getProduct')->name('product.getProduct');
   Route::get('/get/adjustment/product/{id}', 'getAdjustmentProduct')->name('product.getAdjustmentProduct');
});

