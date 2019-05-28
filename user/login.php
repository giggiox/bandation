<?php
$FROMBASE="../";
require_once '../include/classes.php';
session_start();
UserProvider::CheckRememberMe();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php include '../include/css_scripts.php'; ?>
        <link rel="stylesheet" href="../include/scripts/mycss/login.css">
        
        <title>login</title>
    </head>
    <body>
        <?php include '../include/navbar.php';?>

        <div class="container" id="container-login">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">Log In</h5>


                            <form id="log-in-form" class="form-signin" method="POST" action="../controllers/user/login.php">
                                
                                <?php
                                if(isset($_SESSION["tmp_login_message"])){
                                    ?>
                                    <div class="alert alert-warning" role="alert">
                                        <?=$_SESSION["tmp_login_message"]?>
                                    </div>
                                    <?php
                                    unset($_SESSION["tmp_login_message"]);
                                }
                                ?>
                               
                                <div class="form-label-group">
                                    <label for="inputEmail">Email</label>
                                    <input type="text" id="inputEmail" class="form-control" name="email" placeholder="email" value="" autofocus>
                                   
                                </div>
                                <br>

                                <div class="form-label-group">
                                    <label for="inputPassword">Password</label>
                                    <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password">
                                    
                                </div>

                                <br>

                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="rememberme">
                                    <label class="custom-control-label" for="customCheck1">ricorda password</label>
                                </div>
                                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">log in</button>
                                <hr class="my-4">
                                <div class="forgot-pw">
                                    <a href="./resetPassword.php">hai dimenticato la tua password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include '../include/js_scripts.php'; ?>
        <script src="../include/scripts/myjs/login.js"></script>

    </body>
</html>
