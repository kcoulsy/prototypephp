<?php

use Phinx\Migration\AbstractMigration;

class AddUserGroupTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('user_group');
        $table->addColumn('name', 'string', ['limit' => 255])
                ->create();
    }
}
