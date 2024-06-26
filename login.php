<?php

require_once("AbstractPage.php");
require_once("DBUsers.php");
require_once("UsersDbTools.php");
require_once("User.php");

AbstractPage::insertHtmlHead();
AbstractPage::showLoginPanel();

$usersDbTools = new UsersDbTools();


if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $user = $usersDbTools->getUserByToken($token);
    $registrationDate = new DateTime;  
    $usersDbTools->updateUser( $registrationDate->format("Y-m-d H:i:s"), $token);
}

if(isset($_POST['btn-login'])) {
    $loginEmail = $_POST['loginEmail'];
    $loginPassword = $_POST['loginPassword'];
    $savedPassword = $usersDbTools->getUserPasswordByEmail($loginEmail);
    $privilege = $usersDbTools->getUserPrivilegeByEmail($loginEmail);
    if (password_verify($loginPassword,$savedPassword) && $privilege == "Admin")
    {
        header('Location:warehouse.php');
    } 
    else if (password_verify($loginPassword,$savedPassword) && $privilege == "Felhasználó")
    {
        header('Location:warehouseUser.php');
    } 
    else 
    {
        echo 'Invalid password.';
    }

}



?>
