<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsFromSqlDump;
use Illuminate\Database\Seeder;

class RoleDepartmentMenuSeeder extends Seeder
{
    use SeedsFromSqlDump;

    public function run(): void
    {
        $this->seedFromSqlDump('role_department_menu', true);
    }
}
