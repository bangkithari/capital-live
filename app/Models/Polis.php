<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polis extends Model
{
    protected $table = 'polis';

    protected $primaryKey = 'no_polis';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'tgl_exit' => 'datetime',
        'tgl_cetak' => 'datetime',
        'tgl_convert' => 'datetime',
        'nailai_up_max' => 'decimal:2',
    ];
}
