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
        $data = [
            [
                'id' => 30001,
                'username' => 'admintest1',
                'email' => 'admintest1@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30002,
                'username' => 'admintest2',
                'email' => 'admintest2@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30003,
                'username' => 'admintest3',
                'email' => 'admintest3@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30004,
                'username' => 'viptest1',
                'email' => 'viptest1@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30005,
                'username' => 'viptest2',
                'email' => 'viptest2@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30006,
                'username' => 'viptest3',
                'email' => 'viptest3@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30007,
                'username' => 'membertest1',
                'email' => 'membertest1@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30008,
                'username' => 'membertest2',
                'email' => 'membertest2@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ],
            [
                'id' => 30009,
                'username' => 'membertest3',
                'email' => 'membertest3@email.com',
                'password' => password_hash('testpass', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified' => true
            ]
        ];

        $table = $this->table('user');
        $table->insert($data)
                ->save();
    }
}
