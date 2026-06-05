<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AplikasiCif extends Model
{
    protected $table = 'aplikasi_cif';

    protected $primaryKey = 'aplikasi_cif_id';

    public $timestamps = true;

    const UPDATED_AT = 'updated_at';

    protected $guarded = [];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
