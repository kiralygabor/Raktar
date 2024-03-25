<?php

    require_once("AbstractPage.php");
    require_once("BuildingsDbTools.php");
    require_once("StoresDbTools.php");
    require_once("ProductsDbTools.php");

    $buildingsDbTools = new BuildingsDbTools();
    $storesDbTools = new StoresDbTools();
    $productsDbTools = new ProductsDbTools();

    AbstractPage::insertHtmlHead();
    AbstractPage::showHomeBtn();
    $buildings = $buildingsDbTools->getAllBuildings();
    AbstractPage::showDropDown($buildings);
    AbstractPage::showExportDiv();
    AbstractPage::showAddStore();

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
        $buildingId = isset($_POST["buildingDropdown"]) ? $_POST["buildingDropdown"] : '';
        $storesDbTools->deleteStoreById($storeIdToDelete);
        $storages = $storesDbTools->getStoresByBuildingId($buildingId);
    }

    if (isset($_POST['modify_storage'])) {       
        $modifyStoreId = $_POST['modify_storage_id'];
        $storeToModify = $storesDbTools->getStoreById($modifyStoreId);
        AbstractPage::showModifyStore($storeToModify, $modifyStoreId);
    }

    if (isset($_POST['modify_store_submit'])) {
        $modifyStoreId = $_POST['modify_store_id'];
        $modifiedStoreShelves = $_POST['modified_store_shelves'];
        $modifiedStoreShelvesLines = $_POST['modified_store_self_lines'];
        $modifiedStoreProductsName = $_POST['modified_store_products_name'];
        $modifiedProductProductsName = $modifiedStoreProductsName;
        $modifiedStoreQuantity = $_POST['modified_store_quantity'];
        $modifiedStoreMinimumQty = $_POST['modified_store_minimum_qty'];
        $storesDbTools->updateStore($modifiedStoreShelves,$modifiedStoreShelvesLines,$modifiedStoreProductsName,$modifiedProductProductsName,$modifiedStoreQuantity,$modifiedStoreMinimumQty,$modifyStoreId);
        $buildingId = isset($_POST["buildingDropdown"]) ? $_POST["buildingDropdown"] : '';
        $storages = $storesDbTools->getStoresByBuildingId($buildingId);
    }

    if(isset($_POST['add_store'])) {
        $buildingId = isset($_POST["building_id"]) ? $_POST["building_id"] : '';
        $newShelvesName = $_POST['new_shelves_name'];
        $newShelfLinesName = $_POST['new_shelves_lines_name'];
        $newProductsName = $_POST['new_products_name'];
        $newProductName = $_POST['new_products_name'];
        $newProductsQuantity = $_POST['new_products_quantity'];
        $newProductsMinimumQty = $_POST['new_products_minimum_qty'];    
        $storesDbTools->addStore($buildingId, $newShelvesName, $newShelfLinesName, $newProductsName, $newProductName, $newProductsQuantity, $newProductsMinimumQty);
    }

    



?>