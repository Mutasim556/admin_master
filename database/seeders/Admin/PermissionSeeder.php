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
        // Permission::create(['guard_name'=>'admin','name'=>'user-index','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-create','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-update','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-delete','group_name'=>'User Permissions']);

        //permission for role
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-index','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-create','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-update','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-delete','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'specific-permission-create','group_name'=>'Roles And Permissions']);

        //permission for language
        // Permission::create(['guard_name'=>'admin','name'=>'language-index','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-create','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-update','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-delete','group_name'=>'Language Permissions']);

        //backend language permission
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-generate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-translate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-update','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-index','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-api-accesskey','group_name'=>'Backend Language Permissions']);

        //products 
        // unit permission
        // Permission::create(['guard_name'=>'admin','name'=>'unit-index','group_name'=>'Product Units Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'unit-store','group_name'=>'Product Units Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'unit-update','group_name'=>'Product Units Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'unit-delete','group_name'=>'Product Units Permissions']);

        // unit permission
        // Permission::create(['guard_name'=>'admin','name'=>'brand-index','group_name'=>'Product Brands Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'brand-store','group_name'=>'Product Brands Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'brand-update','group_name'=>'Product Brands Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'brand-delete','group_name'=>'Product Brands Permissions']);

        // size permission
        // Permission::create(['guard_name'=>'admin','name'=>'size-index','group_name'=>'Product Sizes Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'size-store','group_name'=>'Product Sizes Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'size-update','group_name'=>'Product Sizes Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'size-delete','group_name'=>'Product Sizes Permissions']);

        // parent category permission
        // Permission::create(['guard_name'=>'admin','name'=>'parent-category-index','group_name'=>'Product Parent Category Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'parent-category-store','group_name'=>'Product Parent Category Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'parent-category-update','group_name'=>'Product Parent Category Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'parent-category-delete','group_name'=>'Product Parent Category Permissions']);

        //category permission
        // Permission::create(['guard_name'=>'admin','name'=>'category-index','group_name'=>'Product Category Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'category-store','group_name'=>'Product Category Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'category-update','group_name'=>'Product Category Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'category-delete','group_name'=>'Product Category Permissions']);

        //products
        Permission::create(['guard_name'=>'admin','name'=>'product-index','group_name'=>'Product Permissions']);
        Permission::create(['guard_name'=>'admin','name'=>'product-store','group_name'=>'Product Permissions']);
        
        //backend settings permission
        // Permission::create(['guard_name'=>'admin','name'=>'maintenance-mode-index','group_name'=>'Settings Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-translate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-update','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-index','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-api-accesskey','group_name'=>'Backend Language Permissions']);

    }
}
