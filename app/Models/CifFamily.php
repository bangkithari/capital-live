<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CifFamily extends Model
{
    protected $table = 'cif_family';

    protected $primaryKey = 'family_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
