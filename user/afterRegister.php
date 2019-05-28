<?php
$FROMBASE="../";
require_once '../include/classes.php';
session_start();
UserProvider::CheckRememberMe();

if(!isset($_SESSION["afterRegister_check"])){ //se si naviga su questa pagina senza prima essersi registrati si viene rimandati indietro
    header("location:./register.php");   
}
unset($_SESSION["afterRegister_check"]);

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php include '../include/css_scripts.php'; ?>
        <link rel="stylesheet" href="../include/scripts/mycss/afterRegister.css">
        
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
                                Controlla la tua casella di posta per attivare l'account.
                                <br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include '../include/js_scripts.php'; ?>

    </body>
</html>
