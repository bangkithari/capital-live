<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsFromSqlDump;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use SeedsFromSqlDump;

    public function run(): void
    {
        $this->seedFromSqlDump('roles', true);
    }
}
