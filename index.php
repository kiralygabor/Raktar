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

<form method="post" enctype="multipart/form-data">
    <input type="file" name="input-file">
    <button type="submit" name="import-btn">Import</button>
    <button type="submit" name="clear-tables-btn">Táblák Kiürítése</button>
    <button type="submit" name="delete-tables-btn">Táblák Törlése</button>
    <button type="submit" name="create-tables">Táblák Létrehozása</button>
    <button type="submit" name="create-database">Adatbázis Létrehozása</button>
    <button type="submit" name="delete-database">Adatbázis Törlése</button>

</form>

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

$db = new DB();
$csvtools = new CsvTools();
$dbBuildings = new DBBuildings();
$dbStores  = new DBStores();
$dbProducts = new DBProducts();
$buildingsDbTools = new BuildingsDbTools();
$storesDbTools = new StoresDbTools();
$productsDbTools = new ProductsDbTools();

if (isset($_POST['import-btn']) && isset($_FILES['input-file']['tmp_name'])) {
    $tmpFilePath = $_FILES['input-file']['tmp_name'];
    $csvtools->importCsv($tmpFilePath, $buildingsDbTools, $storesDbTools, $productsDbTools);

    $csvData = $csvtools->getCsvData($csvtools::FILENAME);
    
    $createBuildingsTable = $dbBuildings->createTable();
    $createStoresTable = $dbStores->createTable();
    $createProductsTable = $dbProducts->createTable();
    
    $truncateBuildingsTable = $csvtools->truncateBuildingsTable($buildingsDbTools,$csvData);
    $truncateStoresTable = $csvtools->truncateStoresTable($storesDbTools,$csvData);
    $truncateProductsTable = $csvtools->truncateProductsTable($productsDbTools,$csvData);
}

if(isset($_POST['clear-tables-btn'])) {
    $buildingsDbTools->truncateBuildings();
    $storesDbTools->truncateStore();
    $productsDbTools->truncateProduct();
    $dbBuildings->createTable();
    $dbStores->createTable();
    $dbProducts->createTable();
}

if(isset($_POST['create-tables'])) {
    $dbBuildings->createTable();
    $dbStores->createTable();
    $dbProducts->createTable();
}

if(isset($_POST['delete-tables-btn'])){
    $buildingsDbTools->deleteBuildings();
    $storesDbTools->deleteStores();
    $productsDbTools->deleteProducts();
}

if(isset($_POST['create-database'])){
    $db->createDatabase();
}

if(isset($_POST['delete-database'])){
    $db->deleteDatabase();
}


?>
