<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Reads INSERT statements for [dbo].[master_produk] from script.sql
     * and executes them directly via DB::unprepared().
     * This table does not use SET IDENTITY_INSERT (PK is varchar, not identity).
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

            // Capture INSERT statements for master_produk
            if (preg_match('/^INSERT\s+\[dbo\]\.\[master_produk\]/i', $trimmed)) {
                $statements[] = $trimmed;
            }
        }

        if (empty($statements)) {
            $this->command->warn('MasterProdukSeeder: No INSERT statements found for master_produk table.');
            return;
        }

        DB::transaction(function () use ($statements) {
            foreach ($statements as $statement) {
                DB::unprepared($statement);
            }
        });

        $this->command->info('MasterProdukSeeder: ' . count($statements) . ' statements executed.');
    }
}
