<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $no_polis
 * @property string $aplikasi_id
 * @property \Illuminate\Support\Carbon|null $tgl_exit
 * @property int $status_polis
 * @property \Illuminate\Support\Carbon|null $tgl_cetak
 * @property \Illuminate\Support\Carbon|null $tgl_convert
 * @property string|null $user_convert
 * @property numeric|null $nailai_up_max
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereAplikasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereNailaiUpMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereNoPolis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereStatusPolis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereTglCetak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereTglConvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereTglExit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Polis whereUserConvert($value)
 * @mixin \Eloquent
 */
class Polis extends Model
{
    protected $table = 'polis';

    protected $primaryKey = 'no_polis';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'tgl_exit' => 'datetime',
        'tgl_cetak' => 'datetime',
        'tgl_convert' => 'datetime',
        'nailai_up_max' => 'decimal:2',
    ];
}
