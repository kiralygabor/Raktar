<?php

require_once "StoresDbTools.php";

$storesDbTools = new StoresDbTools();
$chips = $storesDbTools->getChips();

header('Content-Type: application/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="chips.csv"');
$csvFile = fopen('php://output','w');
fputcsv($csvFile, ['shelves', 'shelf_lines', 'products', 'quantity']);
foreach ($chips as $chip) {
    fputcsv($csvFile,$chip);
}
fclose($csvFile);

?>