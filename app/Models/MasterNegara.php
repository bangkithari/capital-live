<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterNegara extends Model
{
    protected $table = 'master_negara';

    protected $primaryKey = 'country_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
