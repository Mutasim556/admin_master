<?php

namespace App\Models\Admin\Product;

use App\Models\Admin\Settings\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehousePrice extends Model
{
    use HasFactory;
    protected $table = 'warehouse_prices';

    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
