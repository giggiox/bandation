<?php
require_once '../../include/classes.php';
session_start();
$gid=$_POST["group"];
$description=$_POST["description"];
$image=$_FILES["image"];
$name=$gid."_".uniqid().".". pathinfo($image["name"])['extension'];

move_uploaded_file($image["tmp_name"], "../../photos/g_photos/{$name}");
$img=new G_photo(-1, $name, $description, new Group($gid));
G_photoProvider::AddEntity($img);

?>