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


    public function index($columns = '*')
    {
        $query = $this->db->prepare("SELECT $columns FROM users");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, 'App\\Models\\UserModel');
    }


    public function show($id, $columns = '*')
    {
        $query = $this->db->prepare("SELECT $columns FROM users WHERE id = :id");
        $query->execute([ 'id' => $id ]);

        return $query->fetchObject('App\\Models\\UserModel');
    }
}