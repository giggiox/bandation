<?php
require_once '../../include/functions.php';
require_once '../../include/classes.php';
session_start();


$eid=$_POST["event_id"];

//controllo se io sono abilitato a eliminare l'evento
$creator= UserProvider::GetEventCreator(new Event($eid));
if($creator->GetId() != $_SESSION["user"]->GetId()){
    header("location:../../404.php");
    exit();
}



$event=new Event($eid);
EventProvider::DeletEntityByPk($eid);

echo "si";