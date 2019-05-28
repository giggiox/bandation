<?php
require_once '../../include/classes.php';
session_start();

$email=$_GET["email"];
$token=$_GET["token"];

$password_reset=Password_resetProvider::RetriveForEmailToken($email, $token);

if($password_reset==False){
    header("location:../../404.php");
    exit();
}

if(isset($_POST["change_pw_submit"])){
    if($_POST["password"] != $_POST["password_verify"]){ // lo testo server side anche se la validazione in js deve essere gia stata fatta
        header("location:../user/login.php");
    }
    UserProvider::UpdateUserPasswordByMail($email, $_POST["password"]);
    header("location:../../user/login.php");
    exit();
    
    
}

$FROMBASE="../../";
session_start();
UserProvider::CheckRememberMe();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php include '../../include/css_scripts.php'; ?>
        
        
        
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
    </head>
    <body>
        <?php include '../../include/navbar.php';?>

        <div class="container" id="container-login">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">Reset Password</h5>


                            <form id="password-reset" class="form-forgotten-password" method="POST" action="<?=$_SERVER["PHP_SELF"]?>?email=<?=$email?>&token=<?=$token?>">
                               
                                <br>
                                <div class="form-label-group">
                                    <label for="inputpassword">nuova password:</label>
                                    <input type="password" id="inputPassword" class="form-control" name="password" placeholder="new password" value="" autofocus>
                                   
                                </div>
                                <br>
                                 <div class="form-label-group">
                                    <label for="inputpassword">nuova password di nuovo:</label>
                                    <input type="password" id="inputPassword_verify" class="form-control" name="password_verify" placeholder="insert password again" value="" autofocus>
                                   
                                </div>
                                <br>
                                <br>

                                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="change_pw_submit">Sign in</button>
                                <hr class="my-4">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include '../../include/js_scripts.php'; ?>
        <script src="../../include/scripts/myjs/afterPasswordReset.js"></script>

    </body>
</html>
