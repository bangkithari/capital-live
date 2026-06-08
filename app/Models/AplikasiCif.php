<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $aplikasi_cif_id
 * @property string $aplikasi_id
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereAlamatPerusahaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereAplikasiCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereAplikasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereBidangUsaha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereJenisIdentitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereJenisPekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereKewarganegaraan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereMataUang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNamaBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNamaGadisIbuKandung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNamaPemilikRekening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNamaPerusahaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNegaraAsal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNomorHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNomorIdentitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNomorRekening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereStatusPerkawinan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCif whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class AplikasiCif extends Model
{
    protected $table = 'aplikasi_cif';

    protected $primaryKey = 'aplikasi_cif_id';

    public $timestamps = true;

    const UPDATED_AT = 'updated_at';

    protected $guarded = [];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
