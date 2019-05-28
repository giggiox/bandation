<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
session_start();
$gid=$_POST["group_id"];
$group=new Group($gid);

$group_user=new Group_user(-1, "request", $_SESSION["user"], $group);

Group_userProvider::AddEntity($group_user);
echo "si";
?>
