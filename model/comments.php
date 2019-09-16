<?php
class Comments{
 
    // database connection and table name
    private $conn;
    private $table_name = "comments";
 
    // object properties
    public $id;
    public $name;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    function readAll($from_record_num, $records_per_page){
        //select all data
        $query = "SELECT
                    id, content, created_at
                FROM
                    " . $this->table_name . "
                WHERE
                        news_id = " . $_GET['id'] . "
                    AND
                        deleted_at IS NULL
                ORDER BY
                    created_at DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

    // create comment
    function create(){
 
        // posted values
        $this->news_id=$this->news_id;
        $this->content=htmlspecialchars(strip_tags($this->content));
 
        // to get time-stamp for 'created_at and updated_at' field
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    news_id='".$this->news_id."', 
                    content='".filter_var($this->content, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."', 
                    created_at='".$this->created_at."', 
                    updated_at='".$this->updated_at."'";
 
        $stmt = $this->conn->prepare($query);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
 
    }

    // create news
    function delete(){
        // to get time-stamp for 'deleted_at' field
        $this->deleted_at = date('Y-m-d H:i:s');

        //write query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    deleted_at='".$this->deleted_at."'
                WHERE
                    id=".$this->id;
 
        $stmt = $this->conn->prepare($query);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
 
    }

    // used for paging news
    public function countAll(){
     
        $query = "SELECT
                    id
                FROM
                    " . $this->table_name . "
                WHERE
                    deleted_at IS NULL";

     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        $num = $stmt->rowCount();
        return $num;
    }
 
}