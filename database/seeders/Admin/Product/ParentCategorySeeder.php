<?php

namespace Database\Seeders\Admin\Product;

use App\Models\Admin\Product\ParentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parent_category = new ParentCategory();
        $parent_category->parent_category_name = 'Demo';
        $parent_category->parent_category_image = null;
        $parent_category->parent_category_status = 0;
        $parent_category->parent_category_delete = 0;
        $parent_category->parent_category_added_by = 1;
        $parent_category->save();
        
    }
}
