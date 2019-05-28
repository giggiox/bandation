<?php
require_once '../../include/functions.php';
require_once '../../include/classes.php';
session_start();

$gid=$_POST["modify_event_group_id"];

//controllo che io sia amministratore del gruppo di cui abbia fatto la modifica dell'evento
//senno si potrebbe inviare una richiesta in post con qualsiasi gid
$group_user= Group_userProvider::RetriveEntityByUserGroup($_SESSION["user"], new Group($gid));
if($group_user == FALSE || $group_user->GetPrivilege() != "creator"){
    header("location:../../404.php");
    exit();
}


$eid=$_POST["modify_event_form_event_id"];
$title=$_POST["modify_event_form_title"];
$date=$_POST["modify_event_form_date"];
$place=$_POST["modify_event_form_place"];
$response = Google::ValidatePlace($place);
$start_hour=$_POST["modify_event_form_start_hour"];
$end_hour=$_POST["modify_event_form_end_hour"];
$description=$_POST["modify_event_form_description"];

//validazione input lato server
if(empty($title) || empty($description) || empty($date) || empty($start_hour) || empty($place) || empty($end_hour)){
    header("location:../../group/group.php?g=".$gid);
    exit();
}
$event=new Event($eid, $title, $description, $date, $start_hour, $end_hour, $response["place"], $response["lat"], $response["lng"],"n/d");

EventProvider::UpdateEntity($event);

header("location:../../group/group.php?g=$gid");
