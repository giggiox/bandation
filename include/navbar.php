<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?=$FROMBASE?>">Bandation</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <?php if (!isset($_SESSION["user"])): ?> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$FROMBASE."user/login.php"?>">log in </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$FROMBASE."user/register.php"?>">registrati</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION["user"]->GetName() ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?=$FROMBASE.'user/user.php?u='.$_SESSION["user"]->GetId() ?>"><i class="fas fa-user"></i> guarda profilo</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?=$FROMBASE?>controllers/user/logout.php"><i class="fas fa-sign-out-alt"></i> log out</a>
                        </div>
                    </li>
                <?php endif ?>



            </ul>
        </div>
    </div>
</nav><!-- navbar end -->
