<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterProdukPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Reads INSERT statements for [dbo].[master_produk_plan] from script.sql
     * and executes them directly via DB::unprepared().
     * This table does not use SET IDENTITY_INSERT (PK is composite varchar, not identity).
     */
    public function run(): void
    {
        $sqlFile = base_path('script.sql');
        $lines = file($sqlFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $statements = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);

            // Skip GO statements (SQL Server batch separator)
            if (strtoupper($trimmed) === 'GO') {
                continue;
            }

            // Capture INSERT statements for master_produk_plan
            if (preg_match('/^INSERT\s+\[dbo\]\.\[master_produk_plan\]/i', $trimmed)) {
                $statements[] = $trimmed;
            }
        }

        if (empty($statements)) {
            $this->command->warn('MasterProdukPlanSeeder: No INSERT statements found for master_produk_plan table.');
            return;
        }

        DB::transaction(function () use ($statements) {
            foreach ($statements as $statement) {
                DB::unprepared($statement);
            }
        });

        $this->command->info('MasterProdukPlanSeeder: ' . count($statements) . ' statements executed.');
    }
}
