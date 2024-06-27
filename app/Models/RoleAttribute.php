<?php
// app\Models\Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAttribute extends Model
{

    protected $table = 'dp_roles_attribute'; // 指定角色表名称

    protected $primaryKey = 'id'; // 角色表的主键字段名

    protected $fillable = [
        'r_id',
        'r_level',
        'r_now_hp',
        'r_hp',
        'r_min_gjl',
        'r_max_gjl',
        'r_fyl',
        'r_sd',
        'r_bj',
        'r_bjxs',
        'r_exp',
        'r_mb',
        'r_xx',
    ];
}

