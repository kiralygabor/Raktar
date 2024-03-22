<?php

require_once "StoresDbTools.php";

$storesDbTools = new StoresDbTools();
$checks = $storesDbTools->getCheks();

header('Content-Type: application/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="checks.csv"');
$csvFile = fopen('php://output','w');
fputcsv($csvFile, ['buildings','shelves', 'shelf_lines', 'products', 'quantity']);
foreach ($checks as $check) {
    fputcsv($csvFile,$check);
}
fclose($csvFile);

?>