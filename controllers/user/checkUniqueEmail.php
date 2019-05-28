<?php
require_once '../../include/classes.php';
$res=UserProvider::CheckUniqueEmail($_POST["checkEmail"]);
echo $res == True ? 'true' : 'false';
        
