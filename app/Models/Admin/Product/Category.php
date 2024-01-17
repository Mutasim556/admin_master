<?php

namespace App\Models\Admin\Product;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    public function admin(){
        return $this->belongsTo(Admin::class,'category_added_by','id');
    }

    public function parentCategory(){
        return $this->belongsTo(ParentCategory::class,'parent_category_id','id');
    }
}
