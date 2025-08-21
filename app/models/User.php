<?php

namespace app\models;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new \Database();
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

    public function updateUser($id, $email, $image)
    {
        $stmt = $this->db->conn->prepare("UPDATE users SET email = :email, image = :image WHERE id = :id");
        $stmt->execute(['email' => $email, 'image' => $image, 'id' => $id]);
    }

    public function getTotalUsers()
    {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // public function getUsers($pageNum = 1, $usersPerPage = 5, $sort_date = 'desc', $sort_email = 'asc')
    // {
    //     $offset = ($pageNum - 1) * $usersPerPage;
    //     $stmt = $this->db->conn->prepare("SELECT * FROM users ORDER BY email $sort_email,  created_at $sort_date LIMIT :limit OFFSET :offset");
    //     $stmt->bindParam(':limit', $usersPerPage, \PDO::PARAM_INT);
    //     $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchAll(\PDO::FETCH_OBJ);
    // }

    public function getUsers($pageNum = 1, $usersPerPage = 5, $sort_date = '', $sort_email = '')
    {
        $offset = ($pageNum - 1) * $usersPerPage;
        $stmt =  '';

        if ($sort_date) {
            $stmt = $this->db->conn->prepare("SELECT * FROM users ORDER BY created_at $sort_date LIMIT :limit OFFSET :offset");
        }
        if ($sort_email) {
            $stmt = $this->db->conn->prepare("SELECT * FROM users ORDER BY email $sort_email LIMIT :limit OFFSET :offset");
        }
        if (!($sort_date) && !($sort_email)) {
            $stmt = $this->db->conn->prepare("SELECT * FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset");
        }

        $stmt->bindParam(':limit', $usersPerPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public function searchUsers($query)
    {
        $query = "%" . trim($query) . "%";
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE email LIKE :query ORDER BY id DESC");
        $stmt->execute(['query' => $query]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
