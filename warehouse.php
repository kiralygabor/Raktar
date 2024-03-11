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



?>