<?php
require_once '../../include/classes.php';
session_start();
$email=$_POST["email"];
$password=$_POST["password"];
if(empty($email)|| empty($password)){
    header("location:../../user/login.php");
}
$rememberme= isset($_POST["rememberme"]) ? True : False;

$response=UserProvider::Login($email,$password,$rememberme);

if(!$response){
    $_SESSION["tmp_login_message"]="username o password non corretti.";
    header("location:../../user/login.php");
}else{
    $_SESSION["user"]=$response;
    header("location:../../index.php");
}


?>
