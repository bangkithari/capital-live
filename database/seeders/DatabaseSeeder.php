<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role_department_menu')->delete();
        DB::table('users')->delete();
        DB::table('menus')->delete();
        DB::table('master_produk_plan')->delete();
        DB::table('master_produk')->delete();
        DB::table('master_negara')->delete();
        DB::table('master_lookup')->delete();
        DB::table('roles')->delete();
        DB::table('departments')->delete();

        $this->call([
            DepartmentSeeder::class,
            RoleSeeder::class,
            MasterLookupSeeder::class,
            MasterNegaraSeeder::class,
            MasterProdukSeeder::class,
            MasterProdukPlanSeeder::class,
            MenuSeeder::class,
            RoleDepartmentMenuSeeder::class,
            UserSeeder::class,
        ]);
    }
}
