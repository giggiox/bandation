<?php
require_once '../../include/classes.php';
session_start();

$gid=$_POST["group_id"];

//controllo che io sia il creatore di quel gruppo
$creator=UserProvider::GetGroupCreator($gid);
if($creator->GetId() == $_SESSION["user"]->GetId()){
    header("location:../../404.php");
    exit();
}

//adesso dovrei eliminare tutte le dipendenze del gruppo fks...

GroupProvider::DeletEntityByPk($gid);
echo "si";
