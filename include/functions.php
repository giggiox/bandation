<?php

function FormatEventDate($date){
    setlocale(LC_TIME, 'ita');
    $date_c=date_create($date);
    return date_format($date_c,"D d");
}

function FormatEventTime($time){
    return date( 'H:i', strtotime( $time ) );
}

function getBaseUrl() {
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
    $pathInfo = pathinfo($currentPath);

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST'];

    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';

    // return: http://localhost/myproject/
    return $protocol . $hostName . $pathInfo['dirname'] . "/";
}

/*function RememberMe(){
    if(isset($_COOKIE["remember_id"])){
        $id=$_COOKIE["remember_id"];
        $token=$_COOKIE["remember_token"];
        $response=UserProvider::LoginWithCookies($id, $token);
    }
    
}*/