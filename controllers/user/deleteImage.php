<?php
require_once '../../include/classes.php';
session_start();
$path=$_POST["path"];
$uid=$_SESSION["user"]->GetId();
U_photoProvider::DeletEntityByPathUid($path, $uid);
unlink("../../photos/u_photos/".$path);
?>

