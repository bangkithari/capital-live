<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait DeletesStoredFiles
{
    protected static function bootDeletesStoredFiles(): void
    {
        static::deleting(function ($model): void {
            foreach ($model->storedFilePaths() as $path) {
                $model->deleteStoredFile($path);
            }
        });
    }

    /**
     * @return array<int, string|null>
     */
    protected function storedFilePaths(): array
    {
        return [];
    }

    protected function deleteStoredFile(?string $path): void
    {
        $path = $this->normalizeStoredFilePath($path);

        if ($path === null) {
            return;
        }

        if (Storage::exists($path)) {
            Storage::delete($path);

            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function normalizeStoredFilePath(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        $path = trim(str_replace('\\', '/', $path));

        if ($path === '' || preg_match('/^https?:\/\//i', $path)) {
            return null;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return substr($path, strlen('storage/'));
        }

        return $path;
    }
}
