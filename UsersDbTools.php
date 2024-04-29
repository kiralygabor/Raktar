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

    function createUsers($name, $email, $password)
    {
        $user = new User();
        $token = $user->getNewToken();
        $validUntil = $user->getValidUntil();
        $sql = "INSERT INTO " . self::DBTABLE . " (name,email,password,token,token_valid_until) VALUES (?, ?, ?, '$token', '$validUntil')";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt!";
            return false;
        }
        $user->sendRegistrationEmail($token,$email);
        return true;
    }

    function getUserByToken($token)
    {
        $datetime = new DateTime();
        $strDatetime = $datetime->format('Y-m-d H:i:s');
        $query = "SELECT * FROM users WHERE token = $token and token_valid_until > $strDatetime;";
        $stmt = $this->mysqli->prepare($query);
        $result = $stmt->execute();
        return $result->fetch_assoc();
    }

    function updateUser($registrationDate, $token)
    {
        $sql = "UPDATE " . self::DBTABLE . " SET registration_date = ?, is_active = 1 WHERE token = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ss", $registrationDate, $token);
        $result = $stmt->execute();
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