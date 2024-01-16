<?php

namespace App\Models\Admin\Product;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    use HasFactory;
    protected $table = 'parent_categories';

    public function admin(){
        return $this->hasOne(Admin::class,'id','parent_category_added_by');
    }
}
