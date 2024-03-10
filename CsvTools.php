<?php
ini_set('memory_limit','1024M');

class CsvTools{
    const FILENAME  = "adatok.csv";
    public $csvData;
    public $result = [];
    public $buildings = [];
    public $stores = [];
    public $header;
    public $idxBuildings;
    public $idxShelves;
    public $idxLines;
    public $idxObjects;
    public $idxQuantity;
    public $idxBuildingId;

    function __construct(){
        $this->csvData = $this->getCsvData(self::FILENAME);
        $this->header = $this->csvData[0];
        $this->idxBuildings = array_search ('buildings', $this->header);
        $this->idxShelves = array_search ('shelves', $this->header);
        $this->idxLines = array_search ('lines', $this->header);
        $this->idxObjects = array_search ('objects', $this->header);
        $this->idxQuantity = array_search ('quantity', $this->header);
        $this->idxBuildingId = array_search ('building_id', $this->header);
    }

    function getCsvData($fileName)
    {
        if (!file_exists($fileName)) {
            echo "$fileName nem található. ";
            return false;
        }
        $csvFile = fopen($fileName, 'r');
        $lines = [];
        while (! feof($csvFile)) {
            $line = fgetcsv($csvFile);
            $lines[] = $line;
        }
        fclose($csvFile);
        return $lines;
    }

    function getCsvDataFromTmpFile($tmpFilePath) {
        $lines = [];
        $csvFile = fopen($tmpFilePath, 'r');
        while (! feof($csvFile)) {
            $line = fgetcsv($csvFile);
            $lines[] = $line;
        }
        fclose($csvFile);
        return $lines;
    }
    function importCsv($tmpFilePath, $buildingsDbTools, $storesDbTools, $productsDbTools) {
        $csvData = $this->getCsvDataFromTmpFile($tmpFilePath);

        if (empty($csvData)) {
            echo "Nem található adat a CSV fájlban.";
            return false;
        }
        header("Refresh:0"); 
    }

    function getBuildings($csvData)
    {
        if (empty($csvData)) {
            echo "Nincs adat.";
            return false;
        }
        $building = '';
        foreach ($this->csvData as $idx => $line) {
            if(!is_array($line)){
                continue;
            }
            if ($idx == 0) {
                continue;
            }
            if ($building != $line[$this->idxBuildings]){
                $building = $line[$this->idxBuildings];
                $buildings[] = $building;
            }
        }
        return $buildings;
    }

    function getStores($csvData)
    {
        if (empty($csvData)) {
            echo "Nincs adat.";
            return false;
        }
        $shelf = '';
        foreach ($csvData as $idx => $line) {
            if(!is_array($line)){
                continue;
            }
            if ($idx == 0) {
                continue;
            }
                $shelf = $line[$this->idxShelves];
                $shelfLine = $line[$this->idxLines];
                $buildingId = $line[$this->idxBuildingId];
                $stores[] = [$shelf,$shelfLine,$buildingId];
        }
        return $stores;
    }

    function getProducts($csvData)
    {
        if (empty($csvData)) {
            echo "Nincs adat.";
            return false;
        }
        $product = '';
        foreach ($csvData as $idx => $line) {
            if(!is_array($line)){
                continue;
            }
            if ($idx == 0) {
                continue;
            }
                $product = $line[$this->idxObjects];
                $quantity = $line[$this->idxQuantity];
                $products[] = [$product,$quantity];
        }
        return $products;
    }

    function truncateBuildingsTable($buildingsDbTools,$csvData){
        $buildingsDbTools->truncateBuildings();
        $buildings = $this->getBuildings($csvData);
        foreach ($buildings as $building){
            $buildingsDbTools->createBuilding($building);
        }
    }

    function truncateStoresTable($storesDbTools,$csvData){
        $storesDbTools->truncateStore();
        $stores = $this->getStores($csvData);
        foreach ($stores as $store){
            $storesDbTools->createStore($store[0],$store[1],$store[2]);
        }
    }

    function truncateProductsTable($productsDbTools,$csvData){
        $productsDbTools->truncateProduct();
        $products = $this->getProducts($csvData);
        foreach ($products as $product){
            $productsDbTools->createProduct($product[0],$product[1]);
        }
    }



}

?>