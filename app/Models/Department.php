<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }
}
