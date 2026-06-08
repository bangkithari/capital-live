<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\DB;
use RuntimeException;

trait SeedsFromSqlDump
{
    protected function seedFromSqlDump(string $table, bool $usesIdentityInsert = false): void
    {
        $rows = $this->rowsFromSqlDump($table);

        if ($rows === []) {
            return;
        }

        if ($usesIdentityInsert) {
            DB::connection()->getPdo()->exec("SET IDENTITY_INSERT [{$table}] ON");
        }

        try {
            DB::table($table)->delete();
            DB::table($table)->insert($rows);
        } finally {
            if ($usesIdentityInsert) {
                DB::connection()->getPdo()->exec("SET IDENTITY_INSERT [{$table}] OFF");
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function rowsFromSqlDump(string $table): array
    {
        $path = base_path('cpital_live_data.txt');

        if (! is_file($path)) {
            throw new RuntimeException('cpital_live_data.txt not found at project root.');
        }

        $sql = file_get_contents($path);

        if ($sql === false) {
            throw new RuntimeException('Unable to read cpital_live_data.txt.');
        }

        $rows = [];
        $lines = preg_split('/\R/u', $sql) ?: [];

        foreach ($lines as $line) {
            if (! preg_match('/^INSERT INTO `' . preg_quote($table, '/') . '` \((?<columns>.+)\) VALUES \((?<values>.+)\);$/u', $line, $match)) {
                continue;
            }

            $columns = array_map(
                fn (string $column): string => trim($column, " `"),
                explode(',', $match['columns'])
            );

            $values = array_map(
                fn (string $value): mixed => $this->normalizeValue($value),
                $this->splitValues($match['values'])
            );

            $combined = array_combine($columns, $values);

            if ($combined !== false) {
                $rows[] = $combined;
            }
        }

        return $rows;
    }

    /**
     * @return array<int, string>
     */
    protected function splitValues(string $values): array
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

    protected function normalizeValue(string $value): mixed
    {
        $value = trim($value);

        if (strcasecmp($value, 'NULL') === 0) {
            return null;
        }

        if (preg_match("/^N?'(?<text>(?:[^'\\\\]|\\\\.|'')*)'$/u", $value, $match)) {
            $text = str_replace("\\'", "'", $match['text']);
            $text = str_replace("''", "'", $text);

            return $text;
        }

        if (preg_match('/^-?\d+$/', $value)) {
            return (int) $value;
        }

        if (preg_match('/^-?\d+\.\d+$/', $value)) {
            return (float) $value;
        }

        if (str_starts_with($value, 'b\'') && str_ends_with($value, '\'')) {
            return trim($value, "b'");
        }

        if (preg_match('/^CAST\((?<number>[-0-9.]+) AS Decimal\(\d+,\s*\d+\)\)$/u', $value, $match)) {
            return (float) $match['number'];
        }

        return $value;
    }
}
