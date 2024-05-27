<?php
require_once 'UsersInterface.php';
require_once 'DB.php';

class DBUsers extends DB implements UsersInterface
{

    public function createTable(){
        $query = 'CREATE TABLE IF NOT EXISTS users (id int AUTO_INCREMENT PRIMARY KEY, name varchar(50) NOT NULL, email varchar(25) NOT NULL UNIQUE, password varchar(200) NOT NULL, token varchar(100), token_valid_until datetime, registration_date datetime,  is_active tinyint default false, status varchar(50));';
        return $this->mysqli->query($query);
    }

    public function create(array $data): ?int
    {
        $sql = 'INSERT INTO users (%s) VALUES (%s)';
        $fields = '';
        $values = '';
        foreach ($data as $field => $value) {
            if ($fields > '') {
                $fields .= ',' . $field;
            } else
                $fields .= $field;

            if ($values > '') {
                $values .= ',' . "'$value'";
            } else
                $values .= "'$value'";
        }
        $sql = sprintf($sql, $fields, $values);
        $this->mysqli->query($sql);

        $lastInserted = $this->mysqli->query("SELECT LAST_INSERT_ID() id;")->fetch_assoc();

        return $lastInserted['id'];
    }

}