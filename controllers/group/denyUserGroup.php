<?php
require_once '../../include/classes.php';
$gid=$_POST["group"];
$uid=$_POST["user"];
Group_userProvider::RefuseUserToGroup(new User($uid), new Group($gid));
?>