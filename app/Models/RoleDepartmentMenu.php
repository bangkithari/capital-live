<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $role_id
 * @property int $department_id
 * @property int $menu_id
 * @property bool|null $is_access
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu whereIsAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleDepartmentMenu whereRoleId($value)
 * @mixin \Eloquent
 */
class RoleDepartmentMenu extends Model
{
    protected $table = 'role_department_menu';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'is_access' => 'boolean',
    ];
}
