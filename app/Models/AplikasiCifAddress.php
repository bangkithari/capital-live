<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AplikasiCifAddress extends Model
{
    protected $table = 'aplikasi_cif_address';

    protected $primaryKey = 'aplikasi_cif_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'is_primary' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
