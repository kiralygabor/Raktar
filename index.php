<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">
    <link rel="stylesheet" href="css/main.css">
    <title>Főoldal</title>
</head>
<body>

    <header>
        <h1 class="index-header">Raktár projekt</h1>
    </header>

    
    <form method="post" enctype="multipart/form-data">

        <div class="index-buttons">
            <div class="database-buttons">
                <h2>Adatbázis</h2>

                <button type="submit" name="create-database" class="create-database">Adatbázis Létrehozása</button>
                <button type="submit" name="delete-database">Adatbázis Törlése</button>
            </div><br>

            <div class="tables-buttons">
                <h2>Táblák</h2>
                <button type="submit" name="create-tables" class="create-tables">Táblák Létrehozása</button>
                <button type="submit" name="delete-tables-btn">Táblák Törlése</button>
            </div><br>
            
            <div class="import">
                <h2>Adatok</h2>
                <div class="mb-3">
                    <input class="form-control" type="file" id="formFile" name="input-file">
                    <button type="submit" name="import-btn">Import</button>
                    <button type="submit" name="clear-tables-btn">Adatok Törlése</button>
                </div>            
            </div>

            <div class="next-page">
                <h2>Raktár</h2>
                <button><a href="warehouse.php">Benézek a raktárba</a></button>
            </div>

        </div>


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


if(DB::databaseExists()){
    $db = new DB();
    $csvtools = new CsvTools();
    $dbBuildings = new DBBuildings();
    $dbStores  = new DBStores();
    $dbProducts = new DBProducts();
    $buildingsDbTools = new BuildingsDbTools();
    $storesDbTools = new StoresDbTools();
    $productsDbTools = new ProductsDbTools();
}

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
    if(!DB::databaseExists()){
        DB::createDatabase();
    }
    else{
        echo 'Létezik';
    }
}

if(isset($_POST['delete-database'])){
    $db->deleteDatabase();
}





?>
