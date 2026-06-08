<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $aplikasi_cif_id
 * @property string $aplikasi_id
 * @property string $cif_id
 * @property string $address_type
 * @property bool $is_primary
 * @property string $alamat_lengkap
 * @property string|null $rt
 * @property string|null $rw
 * @property string|null $kelurahan
 * @property string|null $kecamatan
 * @property string|null $kota_kabupaten
 * @property string|null $provinsi
 * @property string|null $kode_pos
 * @property string|null $negara
 * @property string|null $no_telp
 * @property string $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereAddressType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereAlamatLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereAplikasiCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereAplikasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereKelurahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereKodePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereKotaKabupaten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereNegara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereProvinsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiCifAddress whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class AplikasiCifAddress extends Model
{
    protected $table = 'aplikasi_cif_address';

    protected $primaryKey = 'aplikasi_cif_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'is_primary' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
