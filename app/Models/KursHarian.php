<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
