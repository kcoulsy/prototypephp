<?php


use Phinx\Seed\AbstractSeed;

class AddInitialUserGroupLinks extends AbstractSeed
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
                'user_id' => 30001, 
                'group_id' => 40001 
            ],
            [
                'user_id' => 30002,
                'group_id' => 40001 
            ],
            [
                'user_id' => 30003, 
                'group_id' => 40001 
            ],
            [
                'user_id' => 30004, 
                'group_id' => 40002 
            ],
            [
                'user_id' => 30005, 
                'group_id' => 40002 
            ],
            [
                'user_id' => 30006, 
                'group_id' => 40002 
            ],
            [
                'user_id' => 30007, 
                'group_id' => 40003
            ],
            [
                'user_id' => 30008,
                'group_id' => 40003
            ],
            [
                'user_id' => 30008,
                'group_id' => 40003
            ]
        ];

        $table = $this->table('user_group_link');
        $table->insert($data)
                ->save();
    }
}
