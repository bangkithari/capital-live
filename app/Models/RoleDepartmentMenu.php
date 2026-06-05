<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleDepartmentMenu extends Model
{
    protected $table = 'role_department_menu';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'is_access' => 'boolean',
    ];
}
