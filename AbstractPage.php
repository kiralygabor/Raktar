<?php

abstract class AbstractPage {

    static function insertHtmlHead()
    {
        echo '<!DOCTYPE html>
    <html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Raktárak</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">
    </head>';   
    }

    static function insertindexHtmlBody()
    {
    echo'<body>

            <header>
                <h1 class="index-header">Raktár projekt</h1>
            </header>

            
            <form method="post" enctype="multipart/form-data">

                <div class="index-buttons">
                    <div class="database-buttons">
                        <h2>Adatbázis</h2>

                        <button type="submit" name="create-database" class="create-database">Adatbázis Létrehozása</button>
                        <button type="submit" name="delete-database">Adatbázis Törlése</button>
                    </div><br>

                    <div class="tables-buttons">
                        <h2>Táblák</h2>
                        <button type="submit" name="create-tables" class="create-tables">Táblák Létrehozása</button>
                        <button type="submit" name="delete-tables-btn">Táblák Törlése</button>
                    </div><br>
                    
                    <div class="import">
                        <h2>Adatok</h2>
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile" name="input-file">
                            <button type="submit" name="import-btn">Import</button>
                            <button type="submit" name="clear-tables-btn">Adatok Törlése</button>
                        </div>            
                    </div>

                    <div class="next-page">
                        <h2>Raktár</h2>
                        <button><a href="warehouse.php">Benézek a raktárba</a></button>
                    </div>

                </div>


            </form>

        </body>
        </html>';
    }

    static function showHomeBtn(){
        echo'
        <body>
        <button><a href="index.php"><i class="fa fa-home" title="Kezdőlap"></i></a></button>
        ';
    }

    static function showExportDiv()
    {
        echo '
            <div class="export">

                <h2>Leltározás</h2>

                <form method="post" action="exportWines.php" class ="wines">
                    <button id="btn-export-wines" name="btn-export-wines" title="Wines">
                        <i class="fa fa-file-excel"></i>&nbsp;Wines</button>
                </form>

                <form method="post" action="exportDrinks.php" class ="drinks">
                    <button id="btn-export-drinks" name="btn-export-drinks" title="Drinks">
                        <i class="fa fa-file-excel"></i>&nbsp;Drinks</button>
                </form>

                <form method="post" action="exportChips.php" class ="chips">
                    <button id="btn-export-chips" name="btn-export-chips" title="Chips">
                        <i class="fa fa-file-excel"></i>&nbsp;Chips</button>
                </form>

                <form method="post" action="exportIceCreams.php" class ="ice-creams">
                    <button id="btn-export-ice-creams" name="btn-export-ice-creams" title="Ice-Creams">
                        <i class="fa fa-file-excel"></i>&nbsp;Ice-Creams</button>
                </form>

                <form method="post" action="exportChecks.php" class ="check">
                    <button id="btn-export-check" name="btn-export-check" title="Check">
                        <i class="fa fa-file-excel"></i>&nbsp;Készletfigyelés</button>
                </form>
            </div>';
    }

    static function showDropDown(array $buildings)
    {
        echo '
            <header>
            <h1 class="storeHeader">Raktárak</h1>
            </header>
            <div class="keres">
            <h2>Keresés</h2>
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <label for="buildingDropdown">Raktár:</label>
            <select id="buildingDropdown" name="buildingDropdown">
            <option value="">Válassz Raktárt</option>';
            foreach ($buildings as $building) {
                echo '<option value="' . $building['id'] . '">' . $building['name'] . '</option>';
                }
            echo '</select>
            <input type="submit" name="submit" value="Küldés"><br>
            <form method="post" action="index.php">
                <input type="text" name="needle" value="">
                <button class="search" type="submit" name="btn-search" method="post">Keres</button>
            </form>
            <br>
            <input type="hidden" name="building_id" id="building_id" value="">
            </form>
            </div>';
    }

    static function showMainTable(array $storages)
    {
        echo '<table class="MainTable">
                <tr>
                    <th>Raktár</th>
                    <th>Polc</th>
                    <th>Sor</th>
                    <th>Áru</th>
                    <th>Mennyiség</th>
                    <th class="muveletek" colspan="2">Műveletek</th>
                </tr>';
        foreach ($storages as $storage) {
            echo '<tr>
                    <td>' . $storage['name'] . '</td>
                    <td>' . $storage['shelves'] . '</td>
                    <td>' . $storage['shelf_lines'] . '</td>
                    <td>' . $storage['products_name'] . '</td>
                    <td>' . $storage['quantity'] . '</td>
                    <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="storage_id" value="' . $storage['id'] . '"><input type="submit" name="delete_storage" value="Törlés"></form></td>
                    <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="modify_storage_id" value="' . $storage['id'] . '"><input type="submit" name="modify_storage" value="Módosítás"></form></td>
                </tr>';
        }
        echo '</table>';
    }

    static function showModifyStore(array $storeToModify, ?int $modifyStoreId)
    {
        echo '
                <div class="modositas">
                <h2>Módosítás</h2>
                
                <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <input type="hidden" name="modify_store_id" value="' . $modifyStoreId . '">

                <label for="modified_store_shelves">Módosított polc:</label>
                <input type="text" id="modified_store_shelves" name="modified_store_shelves" value="' . $storeToModify['shelves'] . '"><br>

                <label for="modified_store_name">Módosított sor:</label>
                <input type="text" id="modified_store_self_lines" name="modified_store_self_lines" value="' . $storeToModify['shelf_lines'] . '"><br>

                <label for="modified_store_name">Módosított áru:</label>
                <input type="text" id="modified_store_products_name" name="modified_store_products_name" value="' . $storeToModify['products_name'] . '"><br>

                <label for="modified_store_name">Módosított áru mennyisége:</label>
                <input type="text" id="modified_store_quantity" name="modified_store_quantity" value="' . $storeToModify['quantity'] . '"><br>

                <label for="modified_store_name">Módosított minimum mennyiség:</label>
                <input type="text" id="modified_store_minimum_qty" name="modified_store_minimum_qty" value="' . $storeToModify['minimum_qty'] . '"><br>

                <input type="submit" name="modify_store_submit" value="Mentés">
            </form>
            </div>';
    }

    static function showAddStore()
    {
        echo '<div class="add">
        
        <h2>Termékfelvétel</h2>

        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        $selectedBuildingId = '';
        if (isset($_POST["buildingDropdown"])) {
            $selectedBuildingId = $_POST["buildingDropdown"];
        }
        echo '<input type="hidden" name="building_id" value="' . $selectedBuildingId . '">

        <label for="new_shelves_name">Új polc neve:</label>
        <input type="text" id="new_shelves_name" name="new_shelves_name" required><br>

        <label for="new_shelves_lines_name">Új sor neve:</label>
        <input type="text" id="new_shelves_lines_name" name="new_shelves_lines_name" required><br>

        <label for="new_products_name">Új áru neve:</label>
        <input type="text" id="new_products_name" name="new_products_name" required><br>

        <label for="new_products_quantity">Új áru mennyisége:</label>
        <input type="text" id="new_products_quantity" name="new_products_quantity" required><br>

        <label for="new_products_minimum_qty">Új áru minimum mennyisége:</label>
        <input type="text" id="new_products_minimum_qty" name="new_products_minimum_qty" required><br>

        <input type="hidden" name="id_building" value="<?php echo $selectedBuildingId; ?>">
        <input type="submit" name="add_store" value="Hozzáad">
        </form>
        </div>';
    }

    static function showPDFButton(){
        echo '
            <div class = pdf>
            <form method="post" action="pdf.php" class ="Pdf">
                <button id="btn-pdf" name="btn-pdf" title="Pdf">
                <i class="fa-solid fa-file-pdf"></i>&nbsp;PDF</button>
            </form>
            </div>';
    }

}

?>