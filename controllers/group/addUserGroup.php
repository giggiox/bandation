<?php
require_once '../../include/classes.php';
$gid=$_POST["group"];
$uid=$_POST["user"];
Group_userProvider::AddUserToGroup(new User($uid), new Group($gid));
?>
