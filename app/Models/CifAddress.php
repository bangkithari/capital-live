<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CifAddress extends Model
{
    protected $table = 'cif_address';

    protected $primaryKey = 'address_id';

    public $timestamps = true;

    protected $fillable = [
        'cif_id',
        'address_type',
        'is_primary',
        'alamat_lengkap',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota_kabupaten',
        'provinsi',
        'kode_pos',
        'negara',
        'no_telp',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cif()
    {
        return $this->belongsTo(Cif::class, 'cif_id', 'cif_id');
    }
}
