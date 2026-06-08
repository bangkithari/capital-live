<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $aplikasi_ahli_waris_id
 * @property string $aplikasi_id
 * @property string $cif_id
 * @property int $no_urut
 * @property numeric $persentase
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris whereAplikasiAhliWarisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris whereAplikasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris whereCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris whereNoUrut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplikasiAhliWaris wherePersentase($value)
 * @mixin \Eloquent
 */
class AplikasiAhliWaris extends Model
{
    protected $table = 'aplikasi_ahli_waris';

    protected $primaryKey = 'aplikasi_ahli_waris_id';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'persentase' => 'decimal:2',
        'created_at' => 'datetime',
    ];
}
