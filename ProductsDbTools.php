<?php

class ProductsDbTools {
    const DBTABLE = 'products';

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

    function createProduct($product,$quantity)
    {
        $sql = "INSERT INTO " . self::DBTABLE . " (name,quantity,minimum_qty) VALUES (?, ?, 10)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $product, $quantity);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt a város beszúrása közben";
            return false;
        }
        return true;
    }

    function truncateProduct()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }

    function deleteProducts()
    {
        $result = $this->mysqli->query("DROP TABLE " . self::DBTABLE);
        return $result;
    }
}