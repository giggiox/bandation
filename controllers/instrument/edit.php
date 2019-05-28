<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
session_start();

$instrument_user_id=$_POST["modify_instrument_user_id"];

$iid=$_POST["modify_instrument_id"];
$start_date=$_POST["modify_instrument_start_date"];
$comment=$_POST["modify_instrument_comment"];

if(empty($iid) || empty($start_date) || empty($comment)){
    header("location:../../user/user.php?u=".$_SESSION["user"]->GetId());
    exit();
}

//l'update attraverso due parametri instrument_user_id e user_id

$instrument_user=new Instrument_user($instrument_user_id, $start_date, $comment,$_SESSION["user"], new Instrument($iid));
//echo "<pre>", print_r($instrument_user),"</pre>";
//exit();
Instrument_userProvider::UpdateEntity($instrument_user);
header("location:../../user/user.php?u=".$_SESSION["user"]->GetId());

