<?php

require_once "StoresDbTools.php";

$storesDbTools = new StoresDbTools();
$drinks = $storesDbTools->getDrinks();

header('Content-Type: application/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="drinks.csv"');
$csvFile = fopen('php://output','w');
fputcsv($csvFile, ['shelves', 'shelf_lines', 'products', 'quantity']);
foreach ($drinks as $drink) {
    fputcsv($csvFile,$drink);
}
fclose($csvFile);

?>