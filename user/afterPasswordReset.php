<?php
$FROMBASE="../";
require_once '../include/classes.php';
session_start();
if(!isset($_SESSION["tmp_pw_reset_msg"])){
    header("location:../");
}
unset($_SESSION["tmp_pw_reset_msg"]);

UserProvider::CheckRememberMe();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php include '../include/css_scripts.php'; ?>
        
        
        
        <style>
            
            body{
                background-color: #009afe;
            }
            #container-login{
                margin-top: 90px;
            }
            .forgot-pw{
                text-align:center;
            }
            
        </style>
        <title>check email</title>
    </head>
    <body>
        <?php include '../include/navbar.php';?>

        <div class="container" id="container-login">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">Quasi finito!</h5>
                            <br><br>
                                <b>Controlla la tua casella di posta per cambiare password</b>
                                <br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include '../include/js_scripts.php'; ?>

    </body>
</html>
