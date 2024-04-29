<?php

require_once("AbstractPage.php");
require_once("DBUsers.php");
require_once("UsersDbTools.php");
require_once("User.php");

AbstractPage::insertHtmlHead();
AbstractPage::showRegistrationPanel();

if(isset($_POST['btn-registration'])) {
    $usersDbTools = new UsersDbTools();
    $user = new User();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $result = $usersDbTools->createUsers($name, $email, $password);
}

