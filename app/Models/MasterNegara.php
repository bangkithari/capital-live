<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $country_id
 * @property string $kd_iso3
 * @property string $kd_iso2
 * @property string $kd_iso_num
 * @property string $nama_negara
 * @property bool|null $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereKdIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereKdIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereKdIsoNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereNamaNegara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterNegara whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class MasterNegara extends Model
{
    protected $table = 'master_negara';

    protected $primaryKey = 'country_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
