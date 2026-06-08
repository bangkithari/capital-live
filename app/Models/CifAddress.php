<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $address_id
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
 * @property-read \App\Models\Cif $cif
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereAddressType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereAlamatLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereKelurahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereKodePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereKotaKabupaten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereNegara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereProvinsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifAddress whereUpdatedBy($value)
 * @mixin \Eloquent
 */
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
