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

    function createStore($buildingId,$shelf,$shelfLine, $proudctsName)
    {
        $sql = "INSERT INTO " . self::DBTABLE . " (buildings_id,shelves,shelf_lines, products_name) VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("isss",$buildingId, $shelf, $shelfLine, $proudctsName);
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

    function deleteStores()
    {
        $result = $this->mysqli->query("DROP TABLE " . self::DBTABLE);
        return $result;
    }

    function deleteStoreById($storeId)
    {
        $sql = "DELETE FROM " . self::DBTABLE . " WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $storeId);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt a raktár törlése közben";
            return false;
        }
        return true;
    }
    
    public function getStoresByBuildingId($buildingId)
    {
        $storages = [];
 
        $query = "SELECT buildings.name, stores.shelves, stores.shelf_lines, stores.products_name, products.quantity, products.id AS id, products.minimum_qty FROM buildings INNER JOIN stores ON buildings.id = stores.buildings_id INNER JOIN products ON stores.products_name = products.name WHERE stores.buildings_id = ?;";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $buildingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $storages = [];
        while ($row = $result->fetch_assoc()) {
            $storages[] = $row;
        }
        $stmt->close();
        return $storages;
   
    }

    public function searchStore($needle)
    {
        $storages = [];
    
        $sql = "SELECT buildings.name, stores.shelves, stores.shelf_lines, stores.products_name, products.quantity, products.id AS id, products.minimum_qty FROM buildings INNER JOIN stores ON buildings.id = stores.buildings_id INNER JOIN products ON stores.products_name = products.name WHERE buildings.name LIKE '%$needle%' OR stores.products_name LIKE '%$needle%';";
        $result = $this->mysqli->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $storages[] = $row;
            }
        }
        return $storages;
    }

    public function getStoreById($storeId) {
        $query = "SELECT buildings.name, stores.shelves, stores.shelf_lines, stores.products_name, products.quantity, products.minimum_qty FROM buildings INNER JOIN stores ON buildings.id = stores.buildings_id INNER JOIN products ON stores.products_name = products.name WHERE stores.id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $storeId);
        $stmt->execute();
        $result = $stmt->get_result();
        $store = $result->fetch_assoc();
        $stmt->close();
        return $store;
    }

    function updateStore($storeShelves, $storeShelfLines, $storeProductsName, $productProductsName, $storeQuantity, $storeMinimumQuntity, $storeId) {
        $sql = "UPDATE buildings INNER JOIN stores ON buildings.id = stores.buildings_id INNER JOIN products ON stores.products_name = products.name SET stores.shelves = ?, stores.shelf_lines = ?, stores.products_name = ?, products.name = ?, products.quantity = ?, products.minimum_qty = ? WHERE stores.id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssssiii",$storeShelves, $storeShelfLines, $storeProductsName, $productProductsName, $storeQuantity, $storeMinimumQuntity, $storeId);
        $result = $stmt->execute();

        if (!$result) {
            echo "Hiba történt a raktár módosítása közben";
            return false;
        }

        return true;
    }

    public function addStore($newStoreName, $newShelvesName, $newShelvesLinesName, $newProductsName, $newProductsQuantity, $newProductsMinimumQty, $buildingId) {
        //$sql = "INSERT INTO (zip_code, city, id_county) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssssiii", $newStoreName, $newShelvesName, $newShelvesLinesName, $newProductsName, $newProductsQuantity, $newProductsMinimumQty, $buildingId);
        $result = $stmt->execute();
 
        if (!$result) {
            echo "Error adding store: " . $this->mysqli->error;
            return false;
        }
 
        return true;
    }

    public function getWines(): array
    {
        $query = "SELECT stores.shelves, stores.shelf_lines, products.name, products.quantity FROM stores INNER JOIN products ON products.name = stores.products_name INNER JOIN buildings ON buildings.id = stores.buildings_id WHERE buildings.id = 1 ORDER BY stores.shelves;";

        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getDrinks(): array
    {
        $query = "SELECT stores.shelves, stores.shelf_lines, products.name, products.quantity FROM stores INNER JOIN products ON products.name = stores.products_name INNER JOIN buildings ON buildings.id = stores.buildings_id WHERE buildings.id = 2 ORDER BY stores.shelves;";

        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getChips(): array
    {
        $query = "SELECT stores.shelves, stores.shelf_lines, products.name, products.quantity FROM stores INNER JOIN products ON products.name = stores.products_name INNER JOIN buildings ON buildings.id = stores.buildings_id WHERE buildings.id = 4 ORDER BY stores.shelves;";

        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getIceCreams(): array
    {
        $query = "SELECT stores.shelves, stores.shelf_lines, products.name, products.quantity FROM stores INNER JOIN products ON products.name = stores.products_name INNER JOIN buildings ON buildings.id = stores.buildings_id WHERE buildings.id = 3 ORDER BY stores.shelves;";

        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getCheks(): array
    {
        $query = "SELECT buildings.name, stores.shelves, stores.shelf_lines, stores.products_name, products.quantity FROM stores INNER JOIN products ON products.name = stores.products_name INNER JOIN buildings ON buildings.id = stores.buildings_id WHERE products.quantity < products.minimum_qty ORDER BY buildings.name;";

        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }
 
}