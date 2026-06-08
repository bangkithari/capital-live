<?php

namespace App\Models;

use App\Models\Concerns\HasEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $cif_id
 * @property string $nama_lengkap
 * @property string|null $jenis_kelamin
 * @property string|null $tempat_lahir
 * @property \Illuminate\Support\Carbon|null $tanggal_lahir
 * @property string|null $nama_gadis_ibu_kandung
 * @property string|null $status_perkawinan
 * @property string|null $agama
 * @property string $kewarganegaraan
 * @property string|null $negara_asal
 * @property string|null $email
 * @property string|null $nomor_hp
 * @property string $jenis_identitas
 * @property string $nomor_identitas
 * @property string|null $npwp
 * @property string $jenis_pekerjaan
 * @property string|null $nama_perusahaan
 * @property string|null $alamat_perusahaan
 * @property string|null $bidang_usaha
 * @property string|null $jabatan
 * @property string $nama_bank
 * @property string $nomor_rekening
 * @property string $mata_uang
 * @property string $nama_pemilik_rekening
 * @property string $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CifAddress> $addresses
 * @property-read int|null $addresses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereAlamatPerusahaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereBidangUsaha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereJenisIdentitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereJenisPekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereKewarganegaraan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereMataUang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNamaBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNamaGadisIbuKandung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNamaPemilikRekening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNamaPerusahaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNegaraAsal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNomorHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNomorIdentitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNomorRekening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereStatusPerkawinan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cif whereUpdatedBy($value)
 * @mixin \Eloquent
 */
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
