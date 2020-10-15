<?php
class Database{
  
    // specify your own database credentials
    // private $host = "localhost";
    // private $db_name = "api-db";
    // private $username = "root";
    // private $password = "";
    // public $conn;

    // specify your own database credentials
    private $host = "eu-cdbr-west-03.cleardb.net";
    private $db_name = "heroku_19d2fdeaff209af";
    private $username = "bc283985bfedac";
    private $password = "b621df3b";
    public $conn;
  //mysql://bc283985bfedac:b621df3b@eu-cdbr-west-03.cleardb.net/heroku_19d2fdeaff209af?reconnect=true
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>