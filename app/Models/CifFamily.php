<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $family_id
 * @property string $cif_id_utama
 * @property string $cif_id_keluarga
 * @property string $hubungan_keluarga
 * @property string $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereCifIdKeluarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereCifIdUtama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereHubunganKeluarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CifFamily whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class CifFamily extends Model
{
    protected $table = 'cif_family';

    protected $primaryKey = 'family_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
