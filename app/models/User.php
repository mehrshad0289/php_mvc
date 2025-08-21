<?php

namespace app\models;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new \Database();
    }

    public function getUsers()
    {
        $stmt = $this->db->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function createUser($email, $password)
    {
        $stmt = $this->db->conn->prepare("INSERT INTO users (email, password) VALUES(:email, :password)");
        $stmt->execute(['email' => $email, 'password' => $password]);
    }
}
