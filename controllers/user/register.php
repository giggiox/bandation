<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
session_start();
$recaptcha=Google::isRecaptchaValid($_POST["g-recaptcha-response"]);
if(!$recaptcha) exit(); //sei un robot!!

$nickname=$_POST["nickname"];
$name=$_POST["name"];
$surname=$_POST["surname"];
$born_date=$_POST["born_date"];
$email=$_POST["email"];
$password=$_POST["password"];
$confirmpassword=$_POST["password_confirmation"];
$status=0;
$place=$_POST["place"];
$place= Google::ValidatePlace($place);
$lat=$place["lat"];
$lng=$place["lng"];
$place=$place["place"];

//server side validazione
if(empty($name) || empty($surname) || empty($born_date) || empty($email) || empty($place) || empty($lat) || empty($lng) || $password!=$confirmpassword || empty($password) || empty($confirmpassword) || strlen($password) <7){
    header("location:../../user/register.php");
    exit();
}


$verify_token=bin2hex(openssl_random_pseudo_bytes(30));
$user=new User(-1, $nickname , $name, $surname, $born_date, $email, $password,"n/d", $verify_token, $status, $lat, $lng, $place);


UserProvider::Register($user);


$message = file_get_contents("../../mail/confirm_registration.html");
$message = str_replace('%email%', $email, $message);
$message = str_replace('%token%', $verify_token, $message);
$message = str_replace("%basepath%", getBaseUrl(), $message);
$message= str_replace("%nome%", $user->GetName(), $message); //Ciao %nome% (Luigi)
Mail::send(Mail::$sender, $email, $message,"Verifica la tua email.");

$_SESSION["afterRegister_check"]=true;
header("location:../../user/afterRegister.php");