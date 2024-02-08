<?php

namespace App\Models\Admin\Product;

use App\Models\Admin;
use App\Models\Admin\Settings\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;
    protected $table = 'adjustments';

    public function warehouse() {
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class,'updated_by','id');
    }
   
}
