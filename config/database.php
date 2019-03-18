<?php

  class database{

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "mydb1";
    public  $conn;

    // CARA MEMBUAT KONEKSI
    public function getConnection(){

      $this->conn = null;

      try{
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
        $this->conn->exec("set names utf8");
      }catch(PDOException $exception){
          echo "Connection error: " . $exception->getMessage();
      }

      return $this->conn;
    }

  }
?>