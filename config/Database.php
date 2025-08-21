<?php

class Database
{
    private $host = "localhost";
    private $dbname = "php_mvc";
    private $username = "root";
    private $password = "";

    public $conn;

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";
        
        try{

            $this->conn = new PDO($dsn, $this->username, $this->password);

        }catch(PDOException $ex){
            echo "Connection Error: " . $ex->getMessage();
        }
    }
}
