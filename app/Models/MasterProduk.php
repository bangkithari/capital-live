<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $kode_produk
 * @property string $nama_produk
 * @property string $kode_mata_uang
 * @property string|null $no_rekening_penerima
 * @property numeric|null $premi_min
 * @property numeric|null $premi_max
 * @property string|null $keterangan
 * @property string $status
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereKodeMataUang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereKodeProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereNamaProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereNoRekeningPenerima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk wherePremiMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk wherePremiMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduk whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class MasterProduk extends Model
{
    protected $table = 'master_produk';

    protected $primaryKey = 'kode_produk';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'premi_min' => 'decimal:2',
        'premi_max' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
