<?php
require_once '../../include/classes.php';
require_once '../../include/functions.php';
session_start();

$name=$_POST["edit_user_name"];
$surname=$_POST["edit_user_surname"];
$nickname=$_POST["edit_user_nickname"];
$place=$_POST["edit_user_place"];
$born_date=$_POST["edit_user_born_date"];

$response=null;
if($_SESSION["user"]->GetPlace() != $place){ // per qualche ragione se il place non viene cambiato lui non lo convalida sicche se non cambia lascio i  vecchi valori senza nemmeno interpellare il server
    $response= Google::ValidatePlace($place);
}else{
    $response["place"]=$_SESSION["user"]->GetPlace();
    $response["lat"]=$_SESSION["user"]->GetLat();
    $response["lng"]=$_SESSION["user"]->GetLng();
}
    
$user=new User($_SESSION["user"]->GetId(), $nickname, $name, $surname, $born_date,"n/d", "n/d", "n/d", "n/d", "n/d", $response["lat"], $response["lng"], $response["place"]);
UserProvider::UpdateEntity($user);
$_SESSION["user"]= UserProvider::RetriveEntityByPk($_SESSION["user"]->GetId()); //referesh dell'user nella sesssione
header("location:../../user/user.php?u=".$_SESSION["user"]->GetId());