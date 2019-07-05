<?php


use Phinx\Seed\AbstractSeed;

class AddInitialUserGroups extends AbstractSeed
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
                'id' => 40001,
                'name' => 'Admin'
            ],
            [
                'id' => 40002,
                'name' => 'Vip'
            ],
            [
                'id' => 40003,
                'name' => 'Member'
            ]
        ];

        $table = $this->table('user_group');
        $table->insert($data)
                ->save();
    }
}
