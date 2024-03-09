<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">
    <title>Főoldal</title>
</head>
<body>
<button><a href="warehouse.php"><i class="fa fa-home" title="Kezdőlap"></i></a></button>
<button>Adatbázis létrehozása<a href="warehouse.php"><i title="Kezdőlap"></i></a></button>
<button>Táblák törlése<a href="warehouse.php"><i title="Kezdőlap"></i></a></button>
</body>
</html>

<?php
require_once("CsvTools.php");
require_once("DBBuildings.php");
require_once("DBStores.php");
require_once("DBProducts.php");
require_once("BuildingsDbTools.php");
require_once("StoresDbTools.php");
require_once("ProductsDbTools.php");

$csvtools = new CsvTools();
$dbBuildings = new DBBuildings();
$dbStores  = new DBStores();
$dbProducts = new DBProducts();
$buildingsDbTools = new BuildingsDbTools();
$storesDbTools = new StoresDbTools();
$productsDbTools = new ProductsDbTools();

$csvData = $csvtools->getCsvData($csvtools::FILENAME);
$getBuildings = $csvtools->getBuildings($csvData);



$createBuildingsTable = $dbBuildings->createTable();
$createStoresTable = $dbStores->createTable();
$createProductsTable = $dbProducts->createTable();

$truncateBuildingsTable = $csvtools->truncateBuildingsTable($buildingsDbTools,$csvData);
$truncateStoresTable = $csvtools->truncateStoresTable($storesDbTools,$csvData);
$truncateProductsTable = $csvtools->truncateProductsTable($productsDbTools,$csvData);
?>
