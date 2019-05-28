<?php
require_once '../../include/functions.php';
require_once '../../include/classes.php';
session_start();

$recaptcha=Google::isRecaptchaValid($_POST["g-recaptcha-response"]);
if(!$recaptcha) exit(); //sei un robot!!

//controllo se la mail esiste (il controllo è gia a vvenuto nella parte grafica)
$email=$_POST["email"];
$user=UserProvider::GetUserByMail($email);
if(!$user) exit();


$token=bin2hex(openssl_random_pseudo_bytes(30));


$password_reset=new Password_reset($email, $token,$user);
Password_resetProvider::AddEntity($password_reset);


$message = file_get_contents("../../mail/password_reset.html");
$message = str_replace('%email%', $email, $message);
$message = str_replace('%token%', $token, $message);
$message = str_replace("%basepath%", getBaseUrl(), $message);

Mail::send(Mail::$sender,$email, $message,"Richiesta di cambio password.");
$_SESSION["tmp_pw_reset_msg"]=true;
header("location:../../user/afterPasswordReset.php");