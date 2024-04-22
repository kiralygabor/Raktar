<?php
require_once("AbstractPage.php");
require_once("CsvTools.php");
require_once("DBBuildings.php");
require_once("DBStores.php");
require_once("DBProducts.php");
require_once("DBUsers.php");
require_once("BuildingsDbTools.php");
require_once("StoresDbTools.php");
require_once("ProductsDbTools.php");
require_once("UsersDbTools.php");

AbstractPage::insertHtmlHead();
AbstractPage::insertindexHtmlBody();

if(DB::databaseExists()){
    $db = new DB();
    $csvtools = new CsvTools();
    $dbBuildings = new DBBuildings();
    $dbStores  = new DBStores();
    $dbProducts = new DBProducts();
    $dbUsers = new DBUsers();
    $buildingsDbTools = new BuildingsDbTools();
    $storesDbTools = new StoresDbTools();
    $productsDbTools = new ProductsDbTools();
    $usersDbTools = new UsersDbTools();
}

if (isset($_POST['import-btn']) && isset($_FILES['input-file']['tmp_name'])) {
    $tmpFilePath = $_FILES['input-file']['tmp_name'];
    $csvtools->importCsv($tmpFilePath, $buildingsDbTools, $storesDbTools, $productsDbTools);

    $csvData = $csvtools->getCsvData($csvtools::FILENAME);
    
    $createBuildingsTable = $dbBuildings->createTable();
    $createStoresTable = $dbStores->createTable();
    $createProductsTable = $dbProducts->createTable();
    $createUsersTable = $dbUsers->createTable();
    
    $truncateBuildingsTable = $csvtools->truncateBuildingsTable($buildingsDbTools,$csvData);
    $truncateStoresTable = $csvtools->truncateStoresTable($storesDbTools,$csvData);
    $truncateProductsTable = $csvtools->truncateProductsTable($productsDbTools,$csvData);
}

if(isset($_POST['clear-tables-btn'])) {
    $buildingsDbTools->truncateBuildings();
    $storesDbTools->truncateStore();
    $productsDbTools->truncateProduct();
    $usersDbTools->truncateUsers();
    $dbBuildings->createTable();
    $dbStores->createTable();
    $dbProducts->createTable();
    $dbUsers->createTable();
}

if(isset($_POST['create-tables'])) {
    $dbBuildings->createTable();
    $dbStores->createTable();
    $dbProducts->createTable();
    $dbUsers->createTable();
}

if(isset($_POST['delete-tables-btn'])){
    $buildingsDbTools->deleteBuildings();
    $storesDbTools->deleteStores();
    $productsDbTools->deleteProducts();
    $usersDbTools->deleteUsers();
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