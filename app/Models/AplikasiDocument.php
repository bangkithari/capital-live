<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use Illuminate\Database\Eloquent\Model;

class AplikasiDocument extends Model
{
    use DeletesStoredFiles;

    protected $table = 'aplikasi_document';

    protected $primaryKey = 'document_aplikasi_id';

    public $timestamps = false;

    protected $fillable = [
        'aplikasi_id',
        'document_type',
        'document_name',
        'file_path',
        'file_extension',
        'file_size_kb',
        'uploaded_by',
        'uploaded_at',
        'remarks',
        'is_active',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * @return array<int, string|null>
     */
    protected function storedFilePaths(): array
    {
        return [$this->file_path];
    }
}
