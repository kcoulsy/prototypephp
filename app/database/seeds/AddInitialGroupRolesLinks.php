<?php


use Phinx\Seed\AbstractSeed;

class AddInitialGroupRolesLinks extends AbstractSeed
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
                'role_id' => 10001,
                'group_id' => 40001
            ],
            [
                'role_id' => 10002,
                'group_id' => 40001
            ],
            [
                'role_id' => 10003,
                'group_id' => 40001
            ],
            [
                'role_id' => 10004,
                'group_id' => 40001
            ]
        ];

        $table = $this->table('group_roles');
        $table->insert($data)
                ->save();
    }
}
