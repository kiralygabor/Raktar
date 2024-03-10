<?php
require_once 'ProductsInterface.php';
require_once 'DB.php';

class DBProducts extends DB implements ProductsInterface
{

    public function createTable(){
        $query = 'CREATE TABLE IF NOT EXISTS products (id int AUTO_INCREMENT PRIMARY KEY, name varchar(35) NOT NULL, quantity int NOT NULL, minimum_qty int NOT NULL, stores_id int)';
        return $this->mysqli->query($query);
    }

    public function create(array $data): ?int
    {
        $sql = 'INSERT INTO products (%s) VALUES (%s)';
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