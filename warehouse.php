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
        $modifiedStoreName = $_POST['modified_store_name'];
        $modifiedStoreShelves = $_POST['modified_store_shelves'];
        $modifiedStoreShelvesLines = $_POST['modified_store_self_lines'];
        $modifiedStoreProductsName = $_POST['modified_store_products_name'];
        $modifiedStoreQuantity = $_POST['modified_store_quantity'];
        $modifiedStoreMinimumQty = $_POST['modified_store_minimum_qty'];
        $storesDbTools->updateStore($modifyStoreId,$modifiedStoreName,$modifiedStoreShelves,$modifiedStoreShelvesLines,$modifiedStoreProductsName,$modifiedStoreQuantity,$modifiedStoreMinimumQty);
        $storages = $storesDbTools->getStoresByBuildingId($buildingId);
    }

    if(isset($_POST['add_store'])) {
        $newStoreName = $_POST['new_store_name'];
        $newShelvesName = $_POST['new_shelves_name'];
        $newShelvesLinesName = $_POST['new_shelves_lines_name'];
        $newProductsName = $_POST['new_products_name'];
        $newProductsQuantity = $_POST['new_products_quantity'];
        $newProductsMinimumQty = $_POST['new_products_minimum_qty'];

        if(!empty($newStoreName) && !empty($newShelvesName) && !empty($newShelvesLinesName) && !empty($newProductsName) && !empty($newProductsQuantity) && !empty($newProductsMinimumQty)) {
            $storesDbTools->addStore($newStoreName, $newShelvesName, $newShelvesLinesName, $newProductsName, $newProductsQuantity, $newProductsMinimumQty, $buildingId);
            $storages = $storesDbTools->getStoresByBuildingId($buildingId);
        }
        else {
            echo "Kérlek töltsd ki az összes mezőt!";
        }
    }

    



?>