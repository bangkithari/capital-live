<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
