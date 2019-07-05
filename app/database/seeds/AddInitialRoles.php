<?php


use Phinx\Seed\AbstractSeed;

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
        $data = [
            [
                'id' => 10001,
                'alias' => 'admin.access',
                'name' => 'Open Admin Panel'
            ],
            [
                'id' => 10002,
                'alias' => 'admin.users.access',
                'name' => 'Access User Management'
            ],
            [
                'id' => 10003,
                'alias' => 'admin.users.manage',
                'name' => 'Manage Users'
            ],
            [
                'id' => 10004,
                'alias' => 'admin.group.access',
                'name' => 'Access Group Management'
            ],
            [
                'id' => 10005,
                'alias' => 'admin.group.manage',
                'name' => 'Manage Groups'
            ],
            [
                'id' => 10006,
                'alias' => 'admin.roles.access',
                'name' => 'Access Roles'
            ],
            [
                'id' => 10007,
                'alias' => 'admin.group.manage.roles',
                'name' => 'Modify Group Roles'
            ],
            [
                'id' => 10008,
                'alias' => 'profile.self.access',
                'name' => 'See Own Profile'
            ]
        ];

        $table = $this->table('role');
        $table->insert($data)
                ->save();
    }
}
