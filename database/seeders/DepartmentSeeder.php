<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsFromSqlDump;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use SeedsFromSqlDump;

    public function run(): void
    {
        $this->seedFromSqlDump('departments', true);
    }
}
