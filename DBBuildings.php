<?php
require_once 'BuildingsInterface.php';
require_once 'DB.php';

class DBBuildings extends DB implements BuildingsInterface
{

    public function createTable(){
        $query = 'CREATE TABLE IF NOT EXISTS buildings (id int AUTO_INCREMENT PRIMARY KEY, name varchar(35) NOT NULL)';
        return $this->mysqli->query($query);
    }

    public function create(array $data): ?int
    {
        $sql = 'INSERT INTO buildings (%s) VALUES (%s)';
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