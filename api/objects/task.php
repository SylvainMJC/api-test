<?php


class Task{
  
    // database connection and table name
    private $conn;
    private $table_name = "tasks";
  
    // object properties
    public $id;
    public $name;
    public $key;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read tasks
function read(){
  
    // select all query
    $query = "SELECT
                `id`,`name`,`key`
            FROM
                " . $this->table_name . "
            ORDER BY
                `key` DESC;";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// used when filling up the update task form
function readOne(){
  
    // query to read single record
    $query = "SELECT
                `id`,`name`,`key`
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of task to be updated
    $stmt->bindParam(1, $this->id);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row){
        // set values to object properties
        $this->name = $row['name'];
        $this->key = $row['key'];
    }
    

}


// create task
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                `name`=:name,`key`=:key;";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->key=htmlspecialchars(strip_tags($this->key));
  
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":key", $this->key);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// update the task
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                `name` = :name,
                `key` = :key
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->key=htmlspecialchars(strip_tags($this->key));
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':key', $this->key);
    $stmt->bindParam(':id', $this->id);
  
    // execute the query

    if($stmt->execute()){
        return true;
    }
  
    return false;
}

// delete the task
function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE `key` = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->key=htmlspecialchars(strip_tags($this->key));

    // bind id of record to delete
    $stmt->bindParam(1, $this->key);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

// search tasks
function search($keywords){
  
    // select all query
    $query = "SELECT
                `id`, `name`, `key`
            FROM
                " . $this->table_name . "
            WHERE
                `name` LIKE ?
            ORDER BY
                `key` DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

}
?>