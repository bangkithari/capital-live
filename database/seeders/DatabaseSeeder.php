<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Runs all seeders in FK-dependency order:
     *   departments → roles → master_lookup → master_negara →
     *   master_produk → master_produk_plan → menus →
     *   role_department_menu → users
     *
     * Each seeder reads raw INSERT statements from script.sql
     * and executes them via DB::unprepared().
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,       // 1. No FK deps
            RoleSeeder::class,             // 2. No FK deps
            MasterLookupSeeder::class,     // 3. No FK deps
            MasterNegaraSeeder::class,     // 4. No FK deps
            MasterProdukSeeder::class,     // 5. No FK deps
            MasterProdukPlanSeeder::class, // 6. FK → master_produk
            MenuSeeder::class,             // 7. Self-ref (parent_id)
            RoleDepartmentMenuSeeder::class, // 8. FK → roles, departments, menus
            UserSeeder::class,             // 9. FK → departments, roles
        ]);
    }
}
