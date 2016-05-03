<?php
namespace App\Repositories\Users;

use App\Databases\MySqlPDODatabase;
use PDO;

class PDOUserRepository implements UserRepositoryInterface
{
	protected $db;

	public function __construct()
	{
		$this->db = MySqlPDODatabase::getInstance();
	}

	public function index()
	{
		$sth = $this->db->prepare("SELECT * FROM users");
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS, 'App\\Models\\UserModel');
	}
}