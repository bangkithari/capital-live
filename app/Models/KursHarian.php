<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $kurs_harian_id
 * @property \Illuminate\Support\Carbon $kurs_date
 * @property string $currency_code
 * @property numeric $kurs_beli
 * @property numeric $kurs_jual
 * @property numeric|null $kurs_tengah
 * @property bool $is_active
 * @property string $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereKursBeli($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereKursDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereKursHarianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereKursJual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereKursTengah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KursHarian whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class KursHarian extends Model
{
    protected $table = 'kurs_harian';

    protected $primaryKey = 'kurs_harian_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'kurs_date' => 'date',
        'kurs_beli' => 'decimal:6',
        'kurs_jual' => 'decimal:6',
        'kurs_tengah' => 'decimal:6',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
