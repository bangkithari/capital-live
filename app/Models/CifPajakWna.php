<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
