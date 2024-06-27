<?php
// app\Models\Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'dp_roles'; // 指定角色表名称

    protected $primaryKey = 'id'; // 角色表的主键字段名

    protected $fillable = [
        'role_id',
        'role_name',
        'account',
        'server_id',
        'gold_coin',
        'guyu',
    ];
}

