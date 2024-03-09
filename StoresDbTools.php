<?php

class StoresDbTools {
    const DBTABLE = 'stores';

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

    function createStore($shelf,$shelfLine,$buildingId)
    {
        $sql = "INSERT INTO " . self::DBTABLE . " (shelves,shelf_lines,buildings_id) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssi", $shelf, $shelfLine, $buildingId);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt a város beszúrása közben";
            return false;
        }
        return true;
    }

    function truncateStore()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }
}