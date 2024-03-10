<?php
require_once 'StoresInterface.php';
require_once 'DB.php';

class DBStores extends DB implements StoresInterface
{

    public function createTable(){
        $query = 'CREATE TABLE IF NOT EXISTS stores (id int AUTO_INCREMENT PRIMARY KEY, shelves varchar(10), shelf_lines varchar(10), buildings_id int NOT NULL);';
        return $this->mysqli->query($query);
    }

    public function create(array $data): ?int
    {
        $sql = 'INSERT INTO stores (%s) VALUES (%s)';
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