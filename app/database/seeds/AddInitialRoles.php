<?php


use Phinx\Seed\AbstractSeed;
use Illuminate\Database\Capsule\Manager as DB;

class AddInitialRoles extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {

        $groups = DB::table('user_group')->get()->keyBy('name')->toArray();

        $admin_category_id = abs( crc32( uniqid() ) );
        $pages_category_id = abs( crc32( uniqid() ) );

        $role_categories = [[
            'id' => $admin_category_id,
            'name' => 'Admin Panel'
        ],[
            'id' => $pages_category_id,
            'name' => 'Pages'
        ]];

        $roles = [[
            'id' => abs( crc32( uniqid() ) ),
            'alias' => 'admin.access',
            'name' => 'Open Admin Panel',
            'role_category_id' => $admin_category_id,
            'hidden' => false,
            'available_to' => ['Admin']
        ],[
            'id' => abs( crc32( uniqid() ) ),
            'alias' => 'admin.roles.access',
            'name' => 'See roles',
            'role_category_id' => $admin_category_id,
            'hidden' => true,
            'available_to' => ['Admin']
        ],[
            'id' => abs( crc32( uniqid() ) ),
            'alias' => 'admin.roles.update',
            'name' => 'Update roles',
            'role_category_id' => $admin_category_id,
            'hidden' => true,
            'available_to' => ['Admin']
        ],[
            'id' => abs( crc32( uniqid() ) ),
            'alias' => 'admin.roles.update',
            'name' => 'See about page',
            'role_category_id' => $pages_category_id,
            'hidden' => false,
            'available_to' => ['Admin', 'Vip', 'Member']
        ]];

        // Adding available to to group roles then unsetting
        $group_roles = [];

        foreach($roles as $index => $role) {
            foreach($role['available_to'] as $group_name) {

                if (isset($groups[$group_name])) {

                    $id = $groups[$group_name]->id;

                    array_push($group_roles, [
                        'id' =>  abs( crc32( uniqid() ) ),
                        'group_id' => $id,
                        'role_id' => $role['id']
                    ]);
                }
                unset($roles[$index]['available_to']);

            }
        }
        var_dump($group_roles);
        // die();
        // die();
        $group_roles_table = $this->table('group_roles');
        // var_dump($group_roles_table);
        $group_roles_table->insert($group_roles)
                ->save();

        $role_table = $this->table('role');
        $role_table->insert($roles)
                ->save();

        $role_category_table = $this->table('role_category');
        $role_category_table->insert($role_categories)
                ->save();

    }
}
