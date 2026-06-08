<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterNegaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Reads INSERT statements for [dbo].[master_negara] from script.sql
     * and executes them directly via DB::unprepared().
     * Includes SET IDENTITY_INSERT ON/OFF statements.
     */
    public function run(): void
    {
        $sqlFile = base_path('script.sql');
        $lines = file($sqlFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $statements = [];
        $capture = false;

        foreach ($lines as $line) {
            $trimmed = trim($line);

            // Skip GO statements (SQL Server batch separator)
            if (strtoupper($trimmed) === 'GO') {
                continue;
            }

            // Capture SET IDENTITY_INSERT ON for master_negara
            if (preg_match('/^SET\s+IDENTITY_INSERT\s+\[dbo\]\.\[master_negara\]\s+ON/i', $trimmed)) {
                $capture = true;
                $statements[] = $trimmed;
                continue;
            }

            // Capture INSERT statements for master_negara
            if (preg_match('/^INSERT\s+\[dbo\]\.\[master_negara\]/i', $trimmed)) {
                $statements[] = $trimmed;
                continue;
            }

            // Capture SET IDENTITY_INSERT OFF for master_negara
            if ($capture && preg_match('/^SET\s+IDENTITY_INSERT\s+\[dbo\]\.\[master_negara\]\s+OFF/i', $trimmed)) {
                $statements[] = $trimmed;
                $capture = false;
                continue;
            }
        }

        if (empty($statements)) {
            $this->command->warn('MasterNegaraSeeder: No INSERT statements found for master_negara table.');
            return;
        }

        DB::transaction(function () use ($statements) {
            foreach ($statements as $statement) {
                DB::unprepared($statement);
            }
        });

        $this->command->info('MasterNegaraSeeder: ' . count($statements) . ' statements executed.');
    }
}
