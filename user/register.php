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
        <link rel="stylesheet" href="../include/scripts/mycss/register.css">
        
        <title>register</title>
    </head>
    <body>
        <?php include '../include/navbar.php'; ?>
        <div class="container" id="container-login">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">Sign In</h5>


                            <form class="form-signin" id="register-form" action="../controllers/user/register.php" method="POST">
                                
                                <div class="form-group">
                                    <label for="email">email: *</label>
                                    <input type="text" value="" class="form-control" name="email" id="email" placeholder="email">

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputnome">nome: *</label>
                                        <input type="text" value="" class="form-control" name="name" placeholder="nome">
                                        
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputcognome">cognome: *</label>
                                        <input type="text" value="" class="form-control" name="surname" placeholder="cognome">
                           
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputnickname">nickname:</label>
                                    <input type="text" value="" class="form-control" name="nickname" placeholder="nickname">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="indirizzo">indirizzo di recapito: *</label>
                                    <input id="autocomplete-user-edit-place" value="" name="place" class="form-control" onFocus="geolocate()" type="text"/>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="datanascita">data di nascita: *</label>
                                    <input type="date" value="" class="form-control" name="born_date" >
                                    
                                </div>

                                <div class="form-label-group">
                                    <label for="inputPassword">Password *</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                                    
                                </div>

                                <div class="form-label-group">
                                    <label for="inputPassword">Password *</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password_confirmation">
                                    
                                </div>
                                
                                <br>
                                <i style="float:right;font-size: 13px;">i campi con (*) sono obbligatori</i>
                                <br>
                                <center><div class="g-recaptcha" data-sitekey="<?=Google::$public_recaptcha_key?>"></div></center>


                                <br>

                                
                                
                                <br>
                                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../include/js_scripts.php'; ?>
        <script src="../include/scripts/myjs/register.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?=Google::$gmaps_key?>&libraries=places"></script>
    <body>

</html>


