<?php

require_once("AbstractPage.php");
require_once("DBUsers.php");
require_once("UsersDbTools.php");

AbstractPage::insertHtmlHead();
AbstractPage::showLoginPanel();

$usersDbTools = new UsersDbTools();


if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $user = $usersDbTools->getUserByToken($token);
    $registrationDate = new DateTime;
    $registrationDate->format("Y-m-d H:i:s");
    $usersDbTools->updateUser($registrationDate, $token);
}



?>
