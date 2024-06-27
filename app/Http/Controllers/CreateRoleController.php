<?php
namespace App\Http\Controllers;

use App\Models\RoleAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class CreateRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showCreateRoleForm()
    {
        return view('create_role');
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:12|unique:dp_roles,role_name', // 添加 unique 验证
        ]);

        $user = Auth::user();

        // 获取当前最大的 role_id
        $maxRoleId = Role::max('role_id');
        $newRoleId = $maxRoleId ? $maxRoleId + 1 : 1;

        // 创建角色并关联到用户
        Role::create([
            'account' => $user->name,
            'role_name' => $request->input('role_name'),
            'role_id' => $newRoleId,
            'server_id' => 1,
        ]);

        RoleAttribute::create([
            'r_id' => $newRoleId,
            'r_level' => 1,
            'r_now_hp' => 500,
            'r_hp' => 500,
            'r_min_gjl' => 20,
            'r_max_gjl' => 30,
            'r_fyl' => 12,
            'r_sd' => 1,
            'r_bj' => 0,
            'r_bjxs' => 0,
        ]);

        $data = [];
        for ($i = 1; $i <= 6; $i++) {
            $tmp['role_id'] = $newRoleId;
            $tmp['e_position'] = $i;
            $tmp['created_at'] = date("Y-m-d H:i:s");
            $data[] = $tmp;
        }
        DB::table('dp_roles_equip')->insert($data);

        // 角色创建成功后重定向到首页
        return redirect('/index');
    }
}
