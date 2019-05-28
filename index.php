<?php
require_once 'include/classes.php';
require_once 'include/functions.php';
session_start();
UserProvider::CheckRememberMe();
$FROMBASE="./";
$events = EventProvider::RetriveEntityList();
$info = [];
$tmp = [];
foreach ($events as $event) {
    $group_user = Group_userProvider::GetEntityByPk($event->GetGroup_user()->GetId());
    $group = GroupProvider::GetEntityByPk($group_user->GetGroup()->GetId());
    $photos = G_photoProvider::RetriveListForGroup($group);
    $photo = isset($photos[0]) ? $photos[0] : null;
    array_push($tmp, ["event" => $event, "group" => $group, "photo" => $photo]);
}

$info["events"] = $tmp;
if (isset($_SESSION["user"])) {
    $groups = GroupProvider::RetriveEntiryList();
    $tmp = [];
    foreach ($groups as $group) {
        $photos = G_photoProvider::RetriveListForGroup($group);
        $photo = isset($photos[0]) ? $photos[0] : null;
        array_push($tmp, ["group" => $group, "photo" => $photo]);
    }
    $info["groups"] = $tmp;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include 'include/css_scripts.php'; ?>
        <title>bandation</title>
        
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <header class="masthead" style="background-image: url('photos/static/back3.png')">

            <div class="container">
                <div class="intro-text">
                    <div class="intro-lead-in">It's Nice To Meet You</div>
                    <div class="intro-heading text-uppercase">Benvenuto!</div>
                    <a class="btn btn-primo btn-xl text-uppercase js-scroll-trigger" href="#info">dimmi di più</a>
                </div>
            </div>

            <div class="masthead-arrow">
                <a href="#map">
                    <i class="fa fa-angle-down bounce" aria-hidden="true"></i>
                </a>
            </div>
        </header>


        <section class="bg-primary" id="info">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="section-heading text-white"> Abbiamo cosa cerchi!</h2>
                        <p class="text-faded mb-4">
                            se non sai dove trovare Eventi Musicali vicino a te oppure vuoi entrare fare parte di una nuova band questo è il posto giusto
                        </p>
                        <a class="btn btn-light btn-xl" id="btn-cerca-eventi" href="#map">Cerca eventi</a>
                        <a class="btn btn-light btn-xl" id="btn-cerca-gruppi" href="#map">Cerca gruppi</a>
                    </div>
                </div>
            </div>
        </section>


        <div id="map"></div>


        <div class="eventi">
            <div id="eventi-header">
                EVENTI
                <hr>
            </div>
            <div class="container" style="background-color:#f7f7f7">
                <div class="slick-carousel">
                    <?php foreach ($info["events"] as $event): ?>

                        <div class="testimonial">
                            <p class="description-date">
                                <i class="fa fa-calendar" aria-hidden="true"></i> <?= FormatEventDate($event["event"]->GetEvent_date()) ?>
                            </p>
                            <div class="testimonial-title">
                                <?= $event["event"]->GetTitle() ?>
                            </div>



                            <p class="description">

                            <br>
                            
                            
                            <table style="width:100%">
                                <tr>
                                    <div class="description-location">
                                        <i class="fa fa-map-marker pre-text" aria-hidden="true"></i><?= $event["event"]->GetPlace() ?>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="description-ora-inizio">
                                        <i class="fas fa-clock pre-text"></i> inizio: <?= FormatEventTime($event["event"]->GetStart_hour()) ?>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="description-bandname">
                                        <i class="fas fa-users pre-text"></i> <?= $event["group"]->GetName() ?>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="description-ora-fine">
                                        <i class="fas fa-clock pre-text"></i> fine: <?= FormatEventTime($event["event"]->GetEnd_hour()) ?>
                                    </div>
                                </tr>
                            </table>
                            
                            
                            
                            

                            <div>
                                <?= $event["event"]->GetDescription() ?>
                            </div>
                            </p>
                            <div class="testimonial-content">
                                <a href="group/group.php?g=<?= $event["group"]->GetId() ?>">
                                    <div class="pic">
                                        <?php $path = isset($event["photo"]) ? "photos/g_photos/" . $event["photo"]->GetPath() : "photos/static/user-default.png" ?>
                                        <img src="<?= $path ?>" class="" alt="" style="background-color: #009afe">
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        </div>


        <div id="button_eventi">
            <input type="button" id="button_eventi_button" class="btn btn-primary custom-gmaps-red" data-toggle="tooltip" trigger="hover" data-placement="right" title="clicca per vedere eventi nelle tue vicinanze!" style="background-image: url('photos/static/red-dot.png');">
        </div>
        <div id="button_gruppi">
            <input type="button" id="button_gruppi_button" class="btn btn-primary custom-gmaps-blue" data-toggle="tooltip" trigger="hover" data-placement="right" title="clicca per vedere gruppi nelle tue vicinanze!" style="background-image: url('photos/static/blue-dot.png');">
        </div>






        <?php include 'include/js_scripts.php'; ?>
        <script src="include/scripts/myjs/welcome.js"></script>

        <script src="https://maps.googleapis.com/maps/api/js?key=<?=Google::$gmaps_key?>&libraries=places"></script>

    </body>


    <script>
        $(document).ready(function () {
            <?php if (isset($_SESSION["user"])): ?>
                mappa(<?= json_encode($info["events"]) ?>,<?= json_encode($info["groups"]) ?>, false);
            <?php else: ?>
                mappa(<?= json_encode($info["events"]) ?>, null, true);
            <?php endif; ?>
            $('[data-toggle="tooltip"]').tooltip({trigger: 'hover focus'})
        });
    </script>
</html>




