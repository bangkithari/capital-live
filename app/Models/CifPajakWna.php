<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $pajak_id
 * @property string $cif_id
 * @property string $jenis_pajak
 * @property string $nomor_pajak
 * @property string|null $negara_pajak
 * @property string $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereCifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereJenisPajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereNegaraPajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereNomorPajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna wherePajakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifPajakWna whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class CifPajakWna extends Model
{
    protected $table = 'cif_pajak_wna';

    protected $primaryKey = 'pajak_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
