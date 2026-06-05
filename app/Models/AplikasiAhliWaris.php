<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
