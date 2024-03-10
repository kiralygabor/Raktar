<?php

class BuildingsDbTools {
    const DBTABLE = 'buildings';

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

    function createBuilding($building)
    {
        $result = $this->mysqli->query("INSERT INTO " . self::DBTABLE . " (name) VALUES ('$building')");
        if (!$result) {
            echo "Hiba történt a $building beszúrása közben";

        }
        return $result;
    }

    function truncateBuildings()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }

    function deleteBuildings()
    {
        $result = $this->mysqli->query("DROP TABLE " . self::DBTABLE);
        return $result;
    }
}
?>