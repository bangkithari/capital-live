<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('EXEC sp_MSforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT ALL"');

        try {
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
        } finally {
            DB::statement('EXEC sp_MSforeachtable "ALTER TABLE ? WITH CHECK CHECK CONSTRAINT ALL"');
        }
    }
}
