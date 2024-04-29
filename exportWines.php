<?php

require_once "StoresDbTools.php";

$storesDbTools = new StoresDbTools();
$wines = $storesDbTools->getWines();

header('Content-Type: application/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="wines.csv"');
$csvFile = fopen('php://output','w');
fputcsv($csvFile, ['shelves', 'shelf_lines', 'products', 'quantity']);
foreach ($wines as $wine) {
    fputcsv($csvFile,$wine);
}
fclose($csvFile);

?>