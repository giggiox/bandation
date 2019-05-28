<?php
$FROMBASE = "../";
require_once '../include/classes.php';
session_start();
UserProvider::CheckRememberMe();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include '../include/css_scripts.php'; ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <title>password reset</title>

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
        <?php include '../include/navbar.php'; ?>

        <div class="container" id="container-login">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">Reset Password</h5>


                            <form id="reset_password_form" class="form-forgotten-password" method="POST" action="../controllers/user/passwordReset.php">

                                <br>
                                <div class="form-label-group">
                                    <label for="inputEmail">Email:</label>
                                    <input type="text" id="inputEmail" class="form-control" name="email" placeholder="Email address" value="" required autofocus>

                                </div>

                                <br>
                                <br>
                                <center><div class="g-recaptcha" data-sitekey="<?= Google::$public_recaptcha_key ?>"></div></center>
                                <br>
                                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
                                <hr class="my-4">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include '../include/js_scripts.php'; ?>


        <script>
            
            //stesso metodo che avvevo usato nel register soltanto al contrario(il false e il true che ritorna)
            var response;
            $.validator.addMethod("uniqueEmail", function(value, element) {
                $.ajax({
                    type: "POST",
                    url: "../controllers/user/checkUniqueEmail.php",
                    async: false, //async perche senno la validazione termina prima che la richiesta ajax magari viene eseguita: guarda https://stackoverflow.com/questions/2628413/jquery-validator-and-a-custom-rule-that-uses-ajax per di piu
                    data: {
                        "checkEmail":value   
                    },
                    dataType: "text",
                    success: function(msg){
                        //se esiste l'email metti la risposta a true
                        response = ( msg == 'true' ) ? false : true;
                    }
                });
                return response;
            });
            
            $("#reset_password_form").validate({
                rules: {
                    email: {
                        email: true,
                        required: true,
                        uniqueEmail: true
                    }
                },
                messages: {
                    email: {
                        email: "inserisi una email valida",
                        required: "inserisci una email",
                        uniqueEmail: "email non esistente"
                    }
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `invalid-feedback` class to the error element
                    error.addClass("invalid-feedback");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.next("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });
        </script>
    </body>
</html>
