<?php

namespace Database\Seeders\Admin\Product;

use App\Models\Admin\Product\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unit = new Unit();
        $unit->unit_code = 'KG';
        $unit->unit_name = 'Kilogram';
        $unit->base_unit = 1;
        $unit->operator = null;
        $unit->operation_value = null;
        $unit->save();
    }
}
