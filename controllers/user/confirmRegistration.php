<?php
if(!isset($_GET["email"]) || !isset($_GET["token"])){
    header("location:../../404.php");
    return;
}

require_once '../../include/classes.php';
$response=UserProvider::VerifyUser($_GET["email"], $_GET["token"]);
if(!$response){
    header("location:.././404.php");
    return;
} else {
    header("location:../../user/login.php");
}