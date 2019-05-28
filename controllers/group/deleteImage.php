<?php
require_once '../../include/classes.php';
session_start();
$path=$_POST["path"];
$gid=$_POST["group_id"];
G_photoProvider::DeletEntityByPathGid($path, $gid);
unlink("../../photos/g_photos/".$path);
?>