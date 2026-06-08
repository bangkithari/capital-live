<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use RuntimeException;

class ScriptSqlDataSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('script.sql');

        if (! is_file($path)) {
            throw new RuntimeException('script.sql not found at project root.');
        }

        $sql = file_get_contents($path);

        if ($sql === false) {
            throw new RuntimeException('Unable to read script.sql.');
        }

        if (str_starts_with($sql, "\xFF\xFE")) {
            $sql = mb_convert_encoding(substr($sql, 2), 'UTF-8', 'UTF-16LE');
        } elseif (str_starts_with($sql, "\xFE\xFF")) {
            $sql = mb_convert_encoding(substr($sql, 2), 'UTF-8', 'UTF-16BE');
        }

        $inserts = $this->parseInserts(preg_split('/\R/u', $sql) ?: []);
        $tables = array_values(array_unique(array_column($inserts, 'table')));

        $this->withoutForeignKeyChecks(function () use ($tables, $inserts) {
            $driver = DB::getDriverName();

            foreach (array_reverse($tables) as $table) {
                DB::table($table)->delete();
            }

            foreach ($inserts as $insert) {
                if ($driver === 'sqlsrv') {
                    try {
                        DB::statement("SET IDENTITY_INSERT [{$insert['table']}] ON");
                    } catch (\Exception $e) {
                        // Table doesn't have identity column, skip
                    }
                }

                DB::table($insert['table'])->insert(
                    array_combine($insert['columns'], $insert['values'])
                );

                if ($driver === 'sqlsrv') {
                    try {
                        DB::statement("SET IDENTITY_INSERT [{$insert['table']}] OFF");
                    } catch (\Exception $e) {
                        // Table doesn't have identity column, skip
                    }
                }
            }
        });
    }

    /**
     * @param array<int, string> $lines
     * @return array<int, array{table: string, columns: array<int, string>, values: array<int, mixed>}>
     */
    private function parseInserts(array $lines): array
    {
        $inserts = [];

        foreach ($lines as $line) {
            if (! preg_match('/^INSERT \[dbo\]\.\[(?<table>[^\]]+)\] \((?<columns>.+)\) VALUES \((?<values>.+)\)$/u', $line, $match)) {
                continue;
            }

            $columns = array_map(
                fn (string $column) => trim($column, " []"),
                explode(',', $match['columns'])
            );

            $values = array_map(
                fn (string $value) => $this->normalizeValue($value),
                $this->splitValues($match['values'])
            );

            $values = $this->sanitizeValues($match['table'], $columns, $values);

            if ($match['table'] === 'menus') {
                [$columns, $values] = $this->normalizeMenuInsert($columns, $values);
            }

            $inserts[] = [
                'table' => $match['table'],
                'columns' => $columns,
                'values' => $values,
            ];
        }

        return $inserts;
    }

    /**
     * @return array<int, string>
     */
    private function splitValues(string $values): array
    {
        $parts = [];
        $buffer = '';
        $depth = 0;
        $inString = false;
        $length = strlen($values);

        for ($i = 0; $i < $length; $i++) {
            $char = $values[$i];
            $next = $values[$i + 1] ?? null;

            if ($char === "'" && $inString && $next === "'") {
                $buffer .= "''";
                $i++;
                continue;
            }

            if ($char === "'") {
                $inString = ! $inString;
            } elseif (! $inString && $char === '(') {
                $depth++;
            } elseif (! $inString && $char === ')') {
                $depth--;
            }

            if (! $inString && $depth === 0 && $char === ',') {
                $parts[] = trim($buffer);
                $buffer = '';
                continue;
            }

            $buffer .= $char;
        }

        if ($buffer !== '') {
            $parts[] = trim($buffer);
        }

        return $parts;
    }

    private function normalizeValue(string $value): mixed
    {
        $value = trim($value);

        if (strcasecmp($value, 'NULL') === 0) {
            return null;
        }

        if (preg_match("/^CAST\\(N?'(?<date>[^']+)' AS DateTime\\)$/u", $value, $match)) {
            return str_replace('T', ' ', $match['date']);
        }

        if (preg_match('/^CAST\((?<number>[-0-9.]+) AS Decimal\(\d+,\s*\d+\)\)$/u', $value, $match)) {
            return $match['number'];
        }

        if (preg_match("/^N?'(?<text>(?:[^']|'')*)'$/u", $value, $match)) {
            return str_replace("''", "'", $match['text']);
        }

        if (preg_match('/^-?\d+$/', $value)) {
            return (int) $value;
        }

        if (preg_match('/^-?\d+\.\d+$/', $value)) {
            return $value;
        }

        if (preg_match('/^0x[0-9A-F]+$/i', $value)) {
            $decoded = hex2bin(substr($value, 2));

            return $decoded === false ? $value : $decoded;
        }

        return $value;
    }

    /**
     * @param array<int, string> $columns
     * @param array<int, mixed> $values
     * @return array<int, mixed>
     */
    private function sanitizeValues(string $table, array $columns, array $values): array
    {
        if ($table !== 'users') {
            return $values;
        }

        $passwordIndex = array_search('password_hash', $columns, true);

        if ($passwordIndex === false) {
            return $values;
        }

        $userIdIndex = array_search('user_id', $columns, true);
        $fallbackPassword = $userIdIndex === false ? 'password' : (string) ($values[$userIdIndex] ?? 'password');
        $values[$passwordIndex] = $this->normalizeBcryptHash($values[$passwordIndex], $fallbackPassword);

        return $values;
    }

    /**
     * @param array<int, string> $columns
     * @param array<int, mixed> $values
     * @return array{0: array<int, string>, 1: array<int, mixed>}
     */
    private function normalizeMenuInsert(array $columns, array $values): array
    {
        $attributes = array_combine($columns, $values);

        if ($attributes === false) {
            return [$columns, $values];
        }

        $code = strtolower(trim((string) ($attributes['code'] ?? '')));
        $attributes['route_name'] = $this->resolveMenuRouteName($code);

        if ($attributes['route_name'] !== null) {
            $attributes['url'] = $this->resolveMenuUrl($attributes['route_name']);
        }

        if ($this->shouldDeactivateMenu($code)) {
            $attributes['is_active'] = 0;
        }

        if (! in_array('route_name', $columns, true)) {
            $columns[] = 'route_name';
        }

        $values = array_map(
            fn (string $column) => $attributes[$column] ?? null,
            $columns
        );

        return [$columns, $values];
    }

    private function resolveMenuRouteName(string $code): ?string
    {
        return match ($code) {
            'dashboard' => Route::has('dashboard') ? 'dashboard' : null,
            'user_mgmt' => Route::has('admin.users.index') ? 'admin.users.index' : null,
            'role_access' => Route::has('admin.role-access.index') ? 'admin.role-access.index' : null,
            default => null,
        };
    }

    private function resolveMenuUrl(?string $routeName): ?string
    {
        if (blank($routeName) || ! Route::has($routeName)) {
            return null;
        }

        return route($routeName, [], false);
    }

    private function shouldDeactivateMenu(string $code): bool
    {
        return in_array($code, [
            'sales_summary',
            'hold_premi_report',
            'submission',
            'approval',
            'cashback',
        ], true);
    }

    private function normalizeBcryptHash(mixed $value, string $fallbackPassword): string
    {
        $hash = is_string($value) ? trim($value) : '';

        if (str_starts_with($hash, '0x') && ctype_xdigit(substr($hash, 2))) {
            $decoded = hex2bin(substr($hash, 2));
            $hash = $decoded === false ? '' : trim($decoded);
        }

        if (preg_match('/^\$2[abxy]\$\d{2}\$[\.\/A-Za-z0-9]{53}$/', $hash) === 1) {
            return '$2y$' . substr($hash, 4);
        }

        return Hash::make($fallbackPassword);
    }

    private function withoutForeignKeyChecks(callable $callback): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        } elseif ($driver === 'sqlsrv') {
            DB::statement('EXEC sp_MSforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT ALL"');
        }

        try {
            $callback();
        } finally {
            if ($driver === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } elseif ($driver === 'sqlite') {
                DB::statement('PRAGMA foreign_keys = ON');
            } elseif ($driver === 'sqlsrv') {
                DB::statement('EXEC sp_MSforeachtable "ALTER TABLE ? WITH CHECK CHECK CONSTRAINT ALL"');
            }
        }
    }
}
