<?php

namespace Database\Seeders\Admin\Product;

use App\Models\Admin\Product\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->parent_category_id = null;
        $category->category_name = 'Test';
        $category->category_image = null;
        $category->category_status = 1;
        $category->category_delete = 0;
        $category->category_added_by = 1;
        $category->save();
    }
}
