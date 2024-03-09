<?php
class DB
{
    
    protected $mysqli;

    function createDatabase(){
        $query = "CREATE DATABASE IF NOT EXISTS warehouse_db;";
        return $this->mysqli->query($query);
    }

    function deleteDatabase()
    {
        $result = $this->mysqli->query("DROP DATABASE warehouse_db;");
        return $result;
    }

    function __construct($host = 'localhost', $user = 'root', $password = null, $database = 'warehouse_db')
    {
        $this->mysqli = mysqli_connect($host, $user, $password, $database);
        if (!$this->mysqli) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    function __destruct()
    {
        $this->mysqli->close();
    }
}

?>