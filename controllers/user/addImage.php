<?php
require_once '../../include/classes.php';
session_start();
$user=$_SESSION["user"];
$id=$user->GetId();
$image=$_FILES["image"];
$name=$id."_".uniqid().".". pathinfo($image["name"])['extension'];

move_uploaded_file($image["tmp_name"], "../../photos/u_photos/{$name}");
$description=$_POST["description"];
$img=new U_photo(-1, $name, $description, $user);
U_photoProvider::AddEntity($img);



?>

