<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $kode_produk
 * @property string $kode_plan
 * @property string $nama_plan
 * @property int $frekuensi_pembayaran_bulan
 * @property int $tenor_bulan
 * @property string $butuh_konfirmasi_cair
 * @property int $batas_konfirmasi_hari
 * @property string|null $keterangan
 * @property string|null $status
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereBatasKonfirmasiHari($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereButuhKonfirmasiCair($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereFrekuensiPembayaranBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereKodePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereKodeProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereNamaPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereTenorBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProdukPlan whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class MasterProdukPlan extends Model
{
    protected $table = 'master_produk_plan';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
