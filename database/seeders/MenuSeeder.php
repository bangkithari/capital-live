<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Reads INSERT statements for [dbo].[menus] from script.sql
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

            // Capture SET IDENTITY_INSERT ON for menus
            if (preg_match('/^SET\s+IDENTITY_INSERT\s+\[dbo\]\.\[menus\]\s+ON/i', $trimmed)) {
                $capture = true;
                $statements[] = $trimmed;
                continue;
            }

            // Capture INSERT statements for menus
            if (preg_match('/^INSERT\s+\[dbo\]\.\[menus\]/i', $trimmed)) {
                $statements[] = $trimmed;
                continue;
            }

            // Capture SET IDENTITY_INSERT OFF for menus
            if ($capture && preg_match('/^SET\s+IDENTITY_INSERT\s+\[dbo\]\.\[menus\]\s+OFF/i', $trimmed)) {
                $statements[] = $trimmed;
                $capture = false;
                continue;
            }
        }

        if (empty($statements)) {
            $this->command->warn('MenuSeeder: No INSERT statements found for menus table.');
            return;
        }

        DB::transaction(function () use ($statements) {
            foreach ($statements as $statement) {
                DB::unprepared($statement);
            }
        });

        $this->command->info('MenuSeeder: ' . count($statements) . ' statements executed.');
    }
}
