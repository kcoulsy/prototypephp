<?php

use Illuminate\Database\Capsule\Manager as DB;

class Roles extends Controller
{
    /**
     * Default
     */
    public function index($params)
    {
        if (isset($params['group_id'])) {
            $group_id = $params['group_id'];
        } else {
            throw new Exception('Param group_id not defined');
        }

        $categories = RoleCategory::get()
                        ->keyBy('id')
                        ->toArray();

        $roles = DB::table('role')
                    ->leftJoin('group_roles', function($join) use ($group_id) {
                        $join->on('role.id', '=', 'group_roles.role_id')
                                ->where('group_roles.group_id', '=', $group_id);
                    })
                    ->select('role.*', 'group_roles.group_id', 'group_roles.role_id')
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
        if (isset($params['group_id'])) {
            $group_id = (int)$params['group_id'];
        } else {
            throw new Exception('Param group_id not defined');
        }

        if (isset($params['role_id'])) {
            $role_id = (int)$params['role_id'];
        } else {
            throw new Exception('Param role_id not defined');
        }

        if (isset($params['enabled'])) {
            $enabled = $params['enabled'];
        } else {
            throw new Exception('Param enabled not defined');
        }

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
