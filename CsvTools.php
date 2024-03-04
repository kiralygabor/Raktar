<?php
ini_set('memory_limit','1024M');

class CsvTools{
    const FILENAME  = "adatok.csv";
    public $csvData;
    public $result = [];
    public $buildings = [];
    public $header;
    public $idxBuildings;
    public $idxShelfs;
    public $idxLines;
    public $idxObjects;
    public $idxQuantity;

    function __construct(){
        $this->csvData = $this->getCsvData(self::FILENAME);
        $this->header = $this->csvData[0];
        $this->idxBuildings = array_search ('buildings', $this->header);
        $this->idxShelfs = array_search ('shelfs', $this->header);
        $this->idxLines = array_search ('lines', $this->header);
        $this->idxObjects = array_search ('objects', $this->header);
        $this->idxQuantity = array_search ('quantity', $this->header);
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

}

?>