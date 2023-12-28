<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creating permission for users
        Permission::create(['guard_name'=>'admin','name'=>'user-index','group_name'=>'User Permissions']);
        Permission::create(['guard_name'=>'admin','name'=>'user-create','group_name'=>'User Permissions']);
        Permission::create(['guard_name'=>'admin','name'=>'user-update','group_name'=>'User Permissions']);
        Permission::create(['guard_name'=>'admin','name'=>'user-delete','group_name'=>'User Permissions']);
    }
}
