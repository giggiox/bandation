<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
session_start();

$name=$_POST["new_group_name"];
$place=$_POST["new_group_place"];
$response= Google::ValidatePlace($place);
$group=new Group(-1, $name, $response["lat"], $response["lng"], $response["place"],$_SESSION["user"]);
$gid=GroupProvider::AddEntity($group);
$group_user=new Group_user(-1, "creator", $_SESSION["user"], new Group($gid));
$gid=Group_userProvider::AddEntity($group_user);

header("location:../../user/user.php?u=".$_SESSION["user"]->GetId());

