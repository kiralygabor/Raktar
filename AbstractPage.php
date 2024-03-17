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
    </head>
    <body>
    
    <h1>Raktárak</h1>';
    }

    static function showDropDown(array $buildings)
    {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <label for="buildingDropdown">Raktár:</label>
            <select id="buildingDropdown" name="buildingDropdown">
            <option value="">Válassz Raktárt</option>';
            foreach ($buildings as $building) {
                echo '<option value="' . $building['id'] . '">' . $building['name'] . '</option>';
                }
            echo '</select>
            <input type="submit" name="submit" value="Küldés">
            <form method="post" action="index.php">
                <input type="text" name="needle" value="">
                <button class="search" type="submit" name="btn-search" method="post">Keres</button>
            </form>
            <br>
            <input type="hidden" name="building_id" id="building_id" value="">
        </form>';
    }

    static function showMainTable(array $storages)
    {
        echo '<table>
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
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <input type="hidden" name="modify_store_id" value="' . $modifyStoreId . '">

                <label for="modified_store_name">Módosított raktár neve:</label>
                <input type="text" id="modified_store_name" name="modified_store_name" value="' . $storeToModify['name'] . '">

                <label for="modified_store_shelves">Módosított polc:</label>
                <input type="text" id="modified_store_shelves" name="modified_store_shelves" value="' . $storeToModify['shelves'] . '">

                <label for="modified_store_name">Módosított sor:</label>
                <input type="text" id="modified_store_self_lines" name="modified_store_self_lines" value="' . $storeToModify['shelf_lines'] . '">

                <label for="modified_store_name">Módosított áru:</label>
                <input type="text" id="modified_store_products_name" name="modified_store_products_name" value="' . $storeToModify['products_name'] . '">

                <label for="modified_store_name">Módosított áru mennyisége:</label>
                <input type="text" id="modified_store_quantity" name="modified_store_quantity" value="' . $storeToModify['quantity'] . '">

                <label for="modified_store_name">Módosított minimum mennyiség:</label>
                <input type="text" id="modified_store_minimum_qty" name="modified_store_minimum_qty" value="' . $storeToModify['minimum_qty'] . '">

                <input type="submit" name="modify_store_submit" value="Mentés">
            </form>';
    }

    static function showAddStore()
    {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        if (isset($_POST["buildingDropdown"])) {
            $selectedBuildingId = isset($_POST["buildingDropdown"]) ? $_POST["buildingDropdown"] : '';
        }
        echo '<input type="hidden" name="building_id" value="' . (isset($selectedBuildingId) ? $selectedBuildingId : '') . '">

        <label for="new_store_name">Új raktár neve:</label>
        <input type="text" id="new_store_name" name="new_store_name">

        <label for="new_shelves_name">Új polc neve:</label>
        <input type="text" id="new_shelves_name" name="new_shelves_name">

        <label for="new_shelves_lines_name">Új sor neve:</label>
        <input type="text" id="new_shelves_lines_name" name="new_shelves_lines_name">

        <label for="new_products_name">Új áru neve:</label>
        <input type="text" id="new_products_name" name="new_products_name">

        <label for="new_products_quantity">Új áru mennyisége:</label>
        <input type="text" id="new_products_quantity" name="new_products_quantity">

        <label for="new_products_minimum_qty">Új áru minimum mennyisége:</label>
        <input type="text" id="new_products_minimum_qty" name="new_products_minimum_qty">

        <input type="hidden" name="id_building" value="<?php echo $selectedBuildingId; ?>">
        <input type="submit" name="add_store" value="Hozzáad">
        </form>';
    }

}

?>