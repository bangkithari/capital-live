<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $document_aplikasi_id
 * @property string $aplikasi_id
 * @property string $document_type
 * @property string $document_name
 * @property string $file_path
 * @property string $file_extension
 * @property int|null $file_size_kb
 * @property string $uploaded_by
 * @property \Illuminate\Support\Carbon $uploaded_at
 * @property string|null $remarks
 * @property bool $is_active
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereAplikasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereDocumentAplikasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereFileExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereFileSizeKb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereUploadedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiDocument whereUploadedBy($value)
 * @mixin \Eloquent
 */
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
