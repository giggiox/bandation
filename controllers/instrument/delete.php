<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
session_start();
$instrument_group_id=$_POST["instrument_group_id"];

//elimino da id del instrument_group e user_id (per essere sicuro che l'user non abbia modificato l'html)
Instrument_userProvider::DeleteEntityByIdAndUid($instrument_group_id,$_SESSION["user"]->GetId());
echo "si";