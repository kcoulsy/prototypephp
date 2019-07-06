<?php

use Illuminate\Database\Capsule\Manager as DB;

class Roles extends Controller
{
    /**
     * Default
     */
    public function index($params)
    {
        $group_id = 40001;

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
}
