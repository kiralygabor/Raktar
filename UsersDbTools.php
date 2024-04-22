<?php

require_once("User.php");
class UsersDbTools {
    const DBTABLE = 'users';

    private $mysqli;

    function __construct($host = 'localhost', $user = 'root', $password = null, $db = 'warehouse_db')
    {
        $this->mysqli = new mysqli($host, $user, $password, $db);
        if ($this->mysqli->connect_errno){
            throw new Exception($this->mysqli->connect_errno);
        }
    }

    function __destruct()
    {
        $this->mysqli->close();
    }

    function createUsers($name, $password, $email)
    {
        $user = new User();
        $token = $user->getNewToken();
        $sql = "INSERT INTO " . self::DBTABLE . " (name,email,password,token) VALUES (?, ?, ?, '$token')";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt!";
            return false;
        }
        return true;
    }

    function truncateUsers()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }

    function deleteUsers()
    {
        $result = $this->mysqli->query("DROP TABLE " . self::DBTABLE);
        return $result;
    }



}
?>