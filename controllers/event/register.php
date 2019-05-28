<?php
require_once '../../include/functions.php';
require_once '../../include/classes.php';
session_start();


$gid=$_POST["group"];

//in questo modo controllo che QUALCUNO non faccia richiesta di fare un evento per un gruppo di cui non fa parte
//l'unica cosa che puo fare è cambiare il gid nell'editor e mettere un gid di cui fa effettivamente parte e è amministratore (crea un evento per il gruppo con il nuovo id)
$group_user=Group_userProvider::RetriveEntityByUserGroup($_SESSION["user"], new Group($gid));
if($group_user==FALSE || $group_user->GetPrivilege() != "creator"){
    header("location:../../404.php");
    exit();
}

$title=$_POST["event_title"];
$description=$_POST["event_description"];
$date=$_POST["event_date"];
$start_hour=$_POST["event_start_hour"];
$end_hour=$_POST["event_end_hour"];
$place=$_POST["event_place"];

//validazione della richiesta lato server
if(empty($title) || empty($description) || empty($date) || empty($start_hour) || empty($place) || empty($end_hour)){
    header("location:../../group/group.php?g=".$gid);
    exit();
}



$response = Google::ValidatePlace($place);
$event=new Event(-1, $title, $description, $date, $start_hour, $end_hour, $response["place"], $response["lat"], $response["lng"],$group_user);

EventProvider::AddEntity($event);

header("location:../../group/group.php?g=".$gid);
?>
