<?php

namespace App\Traits;

use App\Models\Department;

trait HasDepartment
{
    /**
     * Get the default department ID from config.
     */
    protected function defaultDepartmentId(): int
    {
        return Department::firstOrCreate(
            ['code' => config('cpital.default_department_code')],
            ['name' => config('cpital.default_department_name')]
        )->id;
    }
}
