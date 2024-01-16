<?php

namespace Database\Seeders\Admin\Product;

use App\Models\Admin\Product\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $size = new Size();
        $size->size_name = '2 KG';
        $size->size_create_by = 1;
        $size->save();
    }
}
