<?php
require_once("DBUsers.php");
require_once("UsersDbTools.php");
require_once("AbstractPage.php");

$usersDbTools = new UsersDbTools();
class User{

    function __construct(){
        $this->db = new DBUsers();
    }

    function getNewToken(){
        return str_replace(["=", "+"], ["", ""], base64_encode(random_bytes(160/8)));
    }

}

?>