<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('name', 'string', ['limit' => 35]);
        $users->addColumn('surname', 'string', ['limit' => 35]);
        $users->addColumn('password', 'string', ['limit' => 255]);
        $users->addColumn('email', 'string', ['limit' => 150]);
        $users->addColumn('updated_at', 'datetime', ['null' => true]);
        $users->addColumn('created_at', 'datetime', ['null' => true]);
        $users->addIndex('email', 'unique');
        $users->create();
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
