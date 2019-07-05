<?php


use Phinx\Seed\AbstractSeed;

class AddInitialRoleCategories extends AbstractSeed
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
                'id' => 20001,
                'name' => 'Admin Panel'
            ],
            [
                'id' => 20002,
                'name' => 'User Profile'
            ]
        ];

        $table = $this->table('role_category');
        $table->insert($data)
                ->save();
    }
}
