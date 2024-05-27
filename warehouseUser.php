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
    AbstractPage::showPDFButton();

    if (isset($_POST["buildingDropdown"])) 
    {
        $buildingId = isset($_POST["buildingDropdown"]) ? $_POST["buildingDropdown"] : '';
        $storages = $storesDbTools->getStoresByBuildingId($buildingId);

        if (isset($_POST['btn-search'])) {
            $needle = $_POST['needle'];
            $storages = $storesDbTools->searchStore($needle);
        }
       
        if (!empty($storages)) {
            AbstractPage::showMainTableUser($storages);
        }
    }
?>