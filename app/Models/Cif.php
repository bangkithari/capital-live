<?php

namespace App\Models;

use App\Models\Concerns\HasEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;

class Cif extends Model
{
    use HasEncodedRouteKey;

    protected $table = 'cif';

    protected $primaryKey = 'cif_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'cif_id',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_gadis_ibu_kandung',
        'status_perkawinan',
        'agama',
        'kewarganegaraan',
        'negara_asal',
        'email',
        'nomor_hp',
        'jenis_identitas',
        'nomor_identitas',
        'npwp',
        'jenis_pekerjaan',
        'nama_perusahaan',
        'alamat_perusahaan',
        'bidang_usaha',
        'jabatan',
        'nama_bank',
        'nomor_rekening',
        'mata_uang',
        'nama_pemilik_rekening',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function addresses()
    {
        return $this->hasMany(CifAddress::class, 'cif_id', 'cif_id');
    }
}
