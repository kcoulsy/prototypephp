<?php


use Phinx\Seed\AbstractSeed;

class AddInitialUsers extends AbstractSeed
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
        $user_groups = [[
            'id' => abs( crc32( uniqid() ) ),
            'name' => 'Admin'
        ],[
            'id' => abs( crc32( uniqid() ) ),
            'name' => 'Vip'
        ],[
            'id' => abs( crc32( uniqid() ) ),
            'name' => 'Member'
        ]];

        $users = [];
        $user_group_links = [];
        $user_extended = [];

        foreach($user_groups as $group) {
            $group_name = strtolower($group['name']);
            $group_id = $group['id'];

            for ($i = 1; $i < 6; $i++) {
                $user_id = abs( crc32( uniqid() ) );

                array_push($users, [
                    'id' => $user_id,
                    'username' => $group_name . 'test'. $i,
                    'email' => $group_name . 'test'. $i . '@email.com',
                    'password' => password_hash('testpass', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'email_verified' => true
                ]);

                array_push($user_group_links, [
                    'user_id' => $user_id,
                    'group_id' => $group_id
                ]);

                array_push($user_extended, [
                    'user_id' => $user_id,
                    'first_name' => ''. $group_name . $i,
                    'last_name' => 'test',
                    'profile_image' => '/images/profile_default.png'
                ]);
            }
        }

        $user_table = $this->table('user');
        $user_table->insert($users)
                ->save();

        $user_group_table = $this->table('user_group');
        $user_group_table->insert($user_groups)
                ->save();

        $user_group_link_table = $this->table('user_group_link');
        $user_group_link_table->insert($user_group_links)
                ->save();

        $user_extended_table = $this->table('user_extended');
        $user_extended_table->insert($user_extended)
                ->save();
    }
}
