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

    static function showMainTable(array $stores)
    {
        echo '<table>
                <tr>
                    ><th>Polc</th>
                    <th>Sor</th>
                    <th>Mennyiség</th>
                    <th class="muveletek" colspan="2">Műveletek</th>
                </tr>';
        foreach ($stores as $store) {
            echo '<tr>
                    <td>' . $store['shelves'] . '</td>
                    <td>' . $store['shelf_lines'] . '</td>
                    <td>' . $store['county_name'] . '</td>
                    <td>' . $store['county_name'] . '</td>
                    <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="store_id" value="' . $store['id'] . '"><input type="submit" name="delete_store" value="Törlés"></form></td>
                    <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="modify_store_id" value="' . $store['id'] . '"><input type="submit" name="modify_store" value="Módosítás"></form></td>
                </tr>';
        }
        echo '</table>';
    }

}

?>