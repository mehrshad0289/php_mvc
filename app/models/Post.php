<?php

namespace app\models;

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new \Database();
    }

    public function getPosts($pageNum = 1, $postsPerPage = 5)
    {
        $offset = ($pageNum - 1) * $postsPerPage;

        $stmt = $this->db->conn->prepare("SELECT posts.*, categories.title as category_title FROM posts INNER JOIN categories ON posts.category_id = categories.id ORDER BY posts.id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $postsPerPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getTotalPosts()
    {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) FROM posts");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getPost($id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function searchPosts($query)
    {
        $query = "%" . trim($query) . "%";

        $stmt = $this->db->conn->prepare("SELECT posts.*, categories.title as category_title FROM posts INNER JOIN categories ON posts.category_id = categories.id WHERE posts.title LIKE :query OR posts.body LIKE :query ORDER BY posts.id DESC");
        $stmt->execute(['query' => $query]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function createPost($title, $body, $category_id)
    {
        $stmt = $this->db->conn->prepare("INSERT INTO posts (title, body, category_id) VALUES (:title, :body, :category_id)");
        $stmt->execute(['title' => $title, 'body' => $body, 'category_id' => $category_id]);
    }

    public function updatePost($id, $title, $body, $category_id)
    {
        $stmt = $this->db->conn->prepare("UPDATE posts SET title = :title, body = :body, category_id = :category_id WHERE id = :id");

        try {
            $stmt->execute(['id' => $id, 'title' => $title, 'body' => $body, 'category_id' => $category_id]);
        } catch (\PDOException $ex) {
            $_SESSION['error'] = $ex->getMessage();
            exit();
        }

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function deletePost($id)
    {
        $stmt = $this->db->conn->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
