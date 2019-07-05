<?php


use Phinx\Seed\AbstractSeed;

class AddInitialRoleCategoryLinks extends AbstractSeed
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
                'role_id' => 10001, // admin.access
                'category_id' => 20001 // Admin
            ],
            [
                'role_id' => 10002, // admin.users.access
                'category_id' => 20001 // Admin
            ],
            [
                'role_id' => 10003, // admin.users.manage
                'category_id' => 20001 // Admin
            ],
            [
                'role_id' => 10004, // admin.group.access
                'category_id' => 20001 // Admin
            ],
            [
                'role_id' => 10005, // admin.group.manage
                'category_id' => 20001 // Admin
            ],
            [
                'role_id' => 10006, // admin.roles.access
                'category_id' => 20001 // Admin
            ],
            [
                'role_id' => 10007, // admin.group.manage.roles
                'category_id' => 20001 // Admin
            ],
            [
                'role_id' => 10008, // profile.self.access
                'category_id' => 20002 // Profile
            ]
        ];

        $table = $this->table('role_category_link');
        $table->insert($data)
                ->save();
    }
}
