<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProdukPlan extends Model
{
    protected $table = 'master_produk_plan';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
