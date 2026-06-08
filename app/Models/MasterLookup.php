<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $group_code
 * @property string $code
 * @property string $name
 * @property string|null $value
 * @property int|null $sequence
 * @property bool|null $is_active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereGroupCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLookup whereValue($value)
 * @mixin \Eloquent
 */
class MasterLookup extends Model
{
    protected $table = 'master_lookup';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
