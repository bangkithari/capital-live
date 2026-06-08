<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\DB;
use PDO;
use RuntimeException;

trait SeedsFromSqlDump
{
    protected function seedFromSqlDump(string $table, bool $usesIdentityInsert = false): void
    {
        $rows = $this->rowsFromSqlDump($table);

        if ($rows === []) {
            return;
        }

        $pdo = DB::connection()->getPdo();

        if ($usesIdentityInsert) {
            $pdo->exec("SET IDENTITY_INSERT [{$table}] ON");
        }

        try {
            $pdo->beginTransaction();

            try {
                $pdo->exec("DELETE FROM [{$table}]");

                foreach ($rows as $row) {
                    $columns = array_map(
                        static fn (string $column): string => "[{$column}]",
                        array_keys($row)
                    );

                    $values = array_map(
                        fn (mixed $value): string => $this->sqlLiteral($pdo, $value),
                        array_values($row)
                    );

                    $pdo->exec(sprintf(
                        'INSERT INTO [%s] (%s) VALUES (%s)',
                        $table,
                        implode(', ', $columns),
                        implode(', ', $values)
                    ));
                }

                $pdo->commit();
            } catch (\Throwable $throwable) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }

                throw $throwable;
            }
        } finally {
            if ($usesIdentityInsert) {
                $pdo->exec("SET IDENTITY_INSERT [{$table}] OFF");
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function rowsFromSqlDump(string $table): array
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

        $rows = [];
        $lines = preg_split('/\R/u', $sql) ?: [];

        foreach ($lines as $line) {
            if (! preg_match('/^INSERT \[dbo\]\.\[' . preg_quote($table, '/') . '\] \((?<columns>.+)\) VALUES \((?<values>.+)\)$/u', $line, $match)) {
                continue;
            }

            $columns = array_map(
                fn (string $column): string => trim($column, " []"),
                explode(',', $match['columns'])
            );

            $values = array_map(
                fn (string $value): mixed => $this->normalizeValue($value),
                $this->splitValues($match['values'])
            );

            $rows[] = array_combine($columns, $values);
        }

        return array_values(array_filter($rows, static fn ($row): bool => is_array($row)));
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

    protected function sqlLiteral(PDO $pdo, mixed $value): string
    {
        if ($value === null) {
            return 'NULL';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        return $pdo->quote((string) $value);
    }
}
