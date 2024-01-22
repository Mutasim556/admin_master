<?php

namespace App\Models\Admin\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function productVariant(){
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }

    public function warehousePrice(){
        return $this->hasMany(WarehousePrice::class,'product_id','id');
    }
}
