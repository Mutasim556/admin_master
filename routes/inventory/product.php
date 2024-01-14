<?php

use App\Http\Controllers\Admin\Product\UnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->name('product.')->group(function(){

   //units
   Route::resource('unit',UnitController::class);
   Route::controller(UnitController::class)->prefix('unit')->group(function(){
      Route::get('/update/status/{id}/{status}', 'updateStatus');
  });
});