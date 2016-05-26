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
		$users
			->addColumn('name', 'string', ['limit' => 35])
			->addColumn('surname', 'string', ['limit' => 35])
			->addColumn('password', 'string', ['limit' => 255])
			->addColumn('email', 'string', ['limit' => 150])
			->addColumn('updated_at', 'datetime', ['null' => true])
			->addColumn('created_at', 'datetime', ['null' => true])
			->addIndex('email', 'unique')
			->create();
	}

	/**
	 * Migrate Down.
	 */
	public function down()
	{
		$this->dropTable('users');
	}
}
