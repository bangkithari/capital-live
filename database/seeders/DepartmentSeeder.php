<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Reads INSERT statements for [dbo].[departments] from script.sql
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

            // Capture SET IDENTITY_INSERT ON for departments
            if (preg_match('/^SET\s+IDENTITY_INSERT\s+\[dbo\]\.\[departments\]\s+ON/i', $trimmed)) {
                $capture = true;
                $statements[] = $trimmed;
                continue;
            }

            // Capture INSERT statements for departments
            if (preg_match('/^INSERT\s+\[dbo\]\.\[departments\]/i', $trimmed)) {
                $statements[] = $trimmed;
                continue;
            }

            // Capture SET IDENTITY_INSERT OFF for departments
            if ($capture && preg_match('/^SET\s+IDENTITY_INSERT\s+\[dbo\]\.\[departments\]\s+OFF/i', $trimmed)) {
                $statements[] = $trimmed;
                $capture = false;
                continue;
            }
        }

        if (empty($statements)) {
            $this->command->warn('DepartmentSeeder: No INSERT statements found for departments table.');
            return;
        }

        DB::transaction(function () use ($statements) {
            foreach ($statements as $statement) {
                DB::unprepared($statement);
            }
        });

        $this->command->info('DepartmentSeeder: ' . count($statements) . ' statements executed.');
    }
}
