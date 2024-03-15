<?php

    require_once("AbstractPage.php");
    require_once("BuildingsDbTools.php");
    require_once("StoresDbTools.php");
    require_once("ProductsDbTools.php");

    $buildingsDbTools = new BuildingsDbTools();
    $storesDbTools = new StoresDbTools();
    $productsDbTools = new ProductsDbTools();

    AbstractPage::insertHtmlHead();
    $buildings = $buildingsDbTools->getAllBuildings();
    AbstractPage::showDropDown($buildings);

    if (isset($_POST["buildingDropdown"])) 
    {
        $buildingId = isset($_POST["buildingDropdown"]) ? $_POST["buildingDropdown"] : '';
        $storages = $storesDbTools->getStoresByBuildingId($buildingId);

        if (isset($_POST['btn-search'])) {
            $needle = $_POST['needle'];
            $storages = $storesDbTools->searchStore($needle);
        }
       
        if (!empty($storages)) {
            AbstractPage::showMainTable($storages);
        }
    }

    if(isset($_POST['delete_storage'])) {
        $storeIdToDelete = $_POST['storage_id'];
        $storesDbTools->deleteStoreById($storeIdToDelete);
        $storages = $storesDbTools->getStoresByBuildingId($buildingId);
    }

    if (isset($_POST['modify_storage'])) {       
        $modifyStoreId = $_POST['modify_storage_id'];
        $storeToModify = $storesDbTools->getStoreById($modifyStoreId);
        AbstractPage::showModifyCity($storeToModify, $modifyStoreId);
    }

    if (isset($_POST['modify_store_submit'])) {
        $modifyStoreId = $_POST['modify_storage_id'];
        $modifiedStoreName = $_POST['modified_store_name'];
        $modifiedStoreShelves = $_POST['modified_store_shelves'];
        $modifiedStoreShelvesLines = $_POST['modified_store_shelves_lines'];
        $modifiedStoreProductsName = $_POST['modified_store_products_name'];
        $modifiedStoreQuantity = $_POST['modified_store_quantity'];
        $modifiedStoreMinimumQty = $_POST['modified_store_minimum_qty'];
        $storesDbTools->updateStore($modifyStoreId,$modifiedStoreName,$modifiedStoreShelves,$modifiedStoreShelvesLines,$modifiedStoreProductsName,$modifiedStoreQuantity,$modifiedStoreMinimumQty);
        $storages = $storesDbTools->getStoresByBuildingId($buildingId);
    }



?>