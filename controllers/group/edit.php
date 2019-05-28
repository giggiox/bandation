<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
$gid=$_POST["edit_group_id"];
$name=$_POST["edit_group_name"];
$place=$_POST["edit_group_place"];
$response= Google::ValidatePlace($place);
$group=new Group($gid, $name, $response["lat"], $response["lng"], $response["place"]);
GroupProvider::UpdateEntity($group);
header("location:../../group/group.php?g=".$gid);
?>

