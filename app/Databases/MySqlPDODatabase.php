<?php

namespace App\Databases;


use PDO;
use PDOException;


class MySqlPDODatabase implements ConnectionInterface
{
	private static $instance = null;

	private function __clone() { }

	private function __wakeup() { }

	public static function getInstance()
	{
		if (self::$instance == null) {
			try {
				self::$instance = new PDO('mysql:host=' . getenv('PDO_DB_HOST') . ';dbname=' . getenv('PDO_DB_NAME'), getenv('PDO_DB_USER'), getenv('PDO_DB_PASSWORD'));
			} catch (PDOException $e) {
				print "Database Exception " . $e->getMessage();
				die();
			}
		}
		return self::$instance;
	}
}