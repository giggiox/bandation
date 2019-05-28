<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
session_start();

$iid=$_POST["instrument_id"];
$comment=$_POST["intrument_comment"];
$start_date=$_POST["instrument_start_date"];


if(empty($iid) || empty($comment) || empty($start_date)){
    header("location:../../user/user.php?u=".$_SESSION["user"]->GetId());
    exit();
}

$instrument=new Instrument($iid);

$instrument_user=new Instrument_user(-1, $start_date, $comment, $_SESSION["user"], $instrument);



Instrument_userProvider::AddEntity($instrument_user);
header("location:../../user/user.php?u=".$_SESSION["user"]->GetId());
