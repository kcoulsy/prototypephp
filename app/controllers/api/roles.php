<?php

use Illuminate\Database\Capsule\Manager as DB;

class Roles extends Controller
{
    /**
     * Required roles for specific routes
     */
    public $protected_roles = [
        'index' => 'admin.roles.access',
        'update' => 'admin.roles.update'
    ];

    /**
     * Default
     */
    public function index($params)
    {
        $this->requireParams($params, ['group_id']);
        $group_id = $params['group_id'];

        $categories = RoleCategory::get()
                        ->keyBy('id')
                        ->toArray();

        $roles = DB::table('role')
                    ->leftJoin('group_roles', function($join) use ($group_id) {
                        $join->on('role.id', '=', 'group_roles.role_id')
                                ->where('group_roles.group_id', '=', $group_id);
                    })
                    ->select('role.*', 'group_roles.group_id', 'group_roles.role_id')
                    ->where('role.hidden', 'not', true)
                    ->get();

        $non_assigned = [];
        $assigned = [];

        foreach($roles as $role) {
            if ($role->group_id == $group_id) {
                $assigned[$role->role_category_id][] = $role;
            } else {
                $non_assigned[$role->role_category_id][] = $role;
            }
        }

        $output = [
            'assigned' => $assigned,
            'non_assigned' => $non_assigned,
            'categories' => $categories
        ];

        header('Content-type:application/json;charset=utf-8');
        echo json_encode($output);
    }

    /**
     * Update a role for a group
     */
    public function update($params)
    {
        $this->requireParams($params, ['group_id', 'role_id', 'enabled']);
        $role_id = $params['role_id'];
        $group_id = $params['group_id'];
        $enabled = $params['enabled'];

        $role = GroupRoles::where('role_id', '=', $role_id)->where('group_id', '=', $group_id);

        if ($role->get()->count() > 0) {
            // already has the role
            if ($enabled == 'false') {
                $role->first()->delete();
            }
        } else {
            // no roles yet
            if ($enabled == 'true') {
                $new_role = GroupRoles::create([
                    'role_id' => $role_id,
                    'group_id' => $group_id
                ]);
            }
        }
        echo json_encode($params);
    }
}
