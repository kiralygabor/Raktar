<?php

require_once "StoresDbTools.php";

$storesDbTools = new StoresDbTools();
$iceCreams = $storesDbTools->getIceCreams();

header('Content-Type: application/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="icecreams.csv"');
$csvFile = fopen('php://output','w');
fputcsv($csvFile, ['shelves', 'shelf_lines', 'products', 'quantity']);
foreach ($iceCreams as $iceCream) {
    fputcsv($csvFile,$iceCream);
}
fclose($csvFile);

?>