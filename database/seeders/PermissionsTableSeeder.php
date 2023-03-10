<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permission dashboard
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);

        // ----- NEW ----- Form Permissions
        Permission::create(['name' => 'form.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'form.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'form.relation', 'guard_name' => 'web']);

        //permission users
        Permission::create(['name' => 'users.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'web']);

        //permission roles
        Permission::create(['name' => 'roles.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'web']);

        //permission permissions
        Permission::create(['name' => 'permissions.index', 'guard_name' => 'web']);

        Permission::create(['name' => 'form-master_customers.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'form-master_customers.create', 'guard_name' => 'web']);

        Permission::create(['name' => 'form-master_customer_branches.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'form-master_customer_branches.create', 'guard_name' => 'web']);
    }
}