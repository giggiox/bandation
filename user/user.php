<?php
require_once '../include/classes.php';
require_once '../include/functions.php';
session_start();
UserProvider::CheckRememberMe();
$FROMBASE = "../";


$uid = htmlspecialchars($_GET["u"]);

$user = UserProvider::RetriveEntityByPk($uid);
if (is_null($user)) {
    header("location:../404.php");
    exit();
    //echo "errore 404";
}


$u_photos = U_photoProvider::RetriveEntityListForUser($user);

$groups = UserProvider::RetriveGroupAccepted($user);
$groupsphoto = array();
foreach ($groups as $group) {
    $photos = G_photoProvider::RetriveListForGroup($group);
    $photo = isset($photos[0]) ? $photos[0] : null;
    array_push($groupsphoto, ["group" => $group, "g_photo" => $photo]);
}
$eventsgroup = array();
foreach ($groups as $group) {
    $photos = G_photoProvider::RetriveListForGroup($group);
    $photo = isset($photos[0]) ? $photos[0] : null;
    $events = EventProvider::RetriveListForGroup($group);
    //echo "<pre>",print_r($events),"</pre>";
    foreach ($events as $event) {
        array_push($eventsgroup, ["group" => $group, "event" => $event, "g_photo" => $photo]);
    }
}

$instruments=array();
$instrument_user= Instrument_userProvider::RetriveEntityListForUser($user);
foreach ($instrument_user as $instrument_u){
    array_push($instruments,["instrument"=>$instrument_u->GetInstrument(),"instrument_info"=>$instrument_u]);
}


$info = ["user" => $user, "photos" => $u_photos, "groups" => $groupsphoto, "events" => $eventsgroup , "instruments"=>$instruments];

if (isset($_SESSION["user"])) {
    $groups = GroupProvider::RetriveEntiryList();
    $final = [];
    foreach ($groups as $group) {
        $photos = G_photoProvider::RetriveListForGroup($group);
        $photo = isset($photos[0]) ? $photos[0] : null;
        array_push($final, ["group" => $group, "photo" => $photo]);
    }
    $info["allgroups"] = $final;
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include '../include/css_scripts.php'; ?>
        <link rel="stylesheet" href="../include/scripts/mycss/user.css">
        <title><?= $info["user"]->GetNickname() ? $info["user"]->GetNickname() : $info["user"]->GetName() . " " . $info["user"]->GetSurname()?></title>


    </head>
    <body>
        <?php include '../include/navbar.php'; ?>
        <?php
        if (isset($_SESSION["user"]) && $_SESSION["user"]->GetId() == $info["user"]->GetId()): //se sono il "proprietario" della pagina visitata
            include '_edit.php';
            include '_create_group.php';
        endif;
        ?>


        <div class="container user-page">
            <div class="row profile">
                <div class="col-md-3">
                    <div class="profile-sidebar rounded">


                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic text-center">


                            <?php if (count($info["photos"]) > 0): ?>
                                <?php $path = "../photos/u_photos/" . $info["photos"][0]->GetPath(); ?>
                                <a href="<?= $path ?>" data-fancybox="profile" data-caption="<?= $info["photos"][0]->GetDescription() ?>" id="prf-1">
                                    <img src="<?= $path ?>" class="img-fluid" alt="" >
                                </a>
                                <?php for ($i = 1; $i < count($info["photos"]); $i++): ?>
                                    <a href="../photos/u_photos/<?= $info["photos"][$i]->GetPath() ?>" data-fancybox="profile" data-caption="<?= $info["photos"][$i]->GetDescription() ?>" id="prf-<?= $i + 1 ?>"></a>
                                <?php endfor; ?>


                            <?php else: ?>
                                <img src="../photos/static/user-default.png" class="img-fluid" alt="" style="background-color: #009afe" >
                            <?php endif; ?>
                        </div>
                        <!-- END SIDEBAR USERPIC -->


                        <?php if (isset($_SESSION["user"]) && $_SESSION["user"]->GetId() == $info["user"]->GetId()): ?>
                            <div class="buttons-control">
                                <i class="fas fa-plus-circle btns-controls" id="btn-add-image-user"></i> &nbsp;&nbsp;
                                <a class="btn-edit" data-fancybox="edit-user" data-src="#edit-user">
                                    <i class="fas fa-edit btns-controls"></i>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?= $info["user"]->GetNickname() ? $info["user"]->GetNickname() : $info["user"]->GetName() . " " . $info["user"]->GetSurname()?>
                            </div>
                        </div>


                    </div>
                    <br>

                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-events-list" data-toggle="list" href="#list-events" role="tab" aria-controls="events">eventi</a>
                        <a class="list-group-item list-group-item-action" id="list-groups-list" data-toggle="list" href="#list-groups" role="tab" aria-controls="groups">gruppi</a>
                        <a class="list-group-item list-group-item-action" id="list-instruments-list" data-toggle="list" href="#list-instruments" role="tab" aria-controls="instruments">strumenti</a>
                    </div>
                </div><!-- end col md-3-->


                <div class="col-md-9">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active usr" id="list-events" role="tabpanel" aria-labelledby="list-events-list"><!--user events tab-->



                            <div class="user-events">
                                <div class="user-events-heading">
                                    EVENTI
                                    <br>
                                </div>
                                
                                
                                <?php if (count($info["events"]) == 0): ?>
                                        <center><p style="font-weight: bold;font-size: 40px;">
                                                non ci sono eventi in programma.
                                            </p></center>
                                <?php endif; ?>



                                <div class="row">
                                    <?php 
                                    foreach ($info["events"] as $event):
                                        $g_photo = $event["g_photo"];
                                        $group = $event["group"];
                                        $event = $event["event"];

                                        include "_events.php";
                                    endforeach;
                                    ?>
                                </div>

                            </div>




                        </div><!--end user events tab-->


                        <div class="tab-pane fade usr" id="list-groups" role="tabpanel" aria-labelledby="list-groups-list"><!-- user groups tab-->
                            <div class="user-events-heading">
                                GRUPPI
                                <br>
                            </div>
                            <?php if (isset($_SESSION["user"]) && $_SESSION["user"]->GetId() == $info["user"]->GetId()): ?>
                                <a  data-fancybox="create-group" data-src="#create-group">
                                    <button type="button" class="btn btn-primary btn-circle float-right">
                                        <i class="fa fa-plus" aria-hidden="true"></i> crea gruppo
                                    </button>
                                </a>
                                <br><br>
                                
                                <div class="input-group mb-3" style="width:90%;margin-top: 10px" id="search_group">
                                    <input type="text" class="form-control" placeholder="Cerca gruppo..." id="search_group_text">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="button" id="search_group_btn"><i class="fas fa-search"></i></button>
                                    </div>
                                    
                                </div>
                               
                                <div id="found_group_number" style="margin-bottom:40px;">
                                </div>
                                
                                <div style="height: 400px" id="map2"></div>
                            <?php endif; ?>
                            <br>
                            <div class="user-groups">
                                
                                <?php
                                    if(count($info["groups"]) == 0):?>
                                        <br>
                                        <center>
                                            <p style="font-weight: bold;font-size: 40px;">
                                               non ci sono gruppi.
                                            </p>
                                        </center>
                                <?php endif; ?>

                                <section id="portfolio">
                                    <div class="container">
                                        <div class="row">
                                            <?php
                                            foreach ($info["groups"] as $group):
                                                $g_photo = $group["g_photo"];
                                                $group = $group["group"];
                                                include '_groups.php';

                                            endforeach;
                                            ?>
                                        </div>
                                    </div>
                                </section>
                            </div>


                        </div><!-- end user groups tab-->



                        <div class="tab-pane fade usr" id="list-instruments" role="tabpanel" aria-labelledby="list-instruments-list"><!-- instrument user tab-->
                            <div class="user-events-heading">
                                    STRUMENTI
                                    <br>
                            </div>
                            <?php if (isset($_SESSION["user"]) && $_SESSION["user"]->GetId() == $info["user"]->GetId()): ?>
                            <?php include '_create_instrument.php'; 
                                  include '_modify_instrument.php';
                            ?>
                                <br>
                                <a  data-fancybox="add-instrument" data-src="#add-instrument">
                                    <button type="button" class="btn btn-primary btn-circle float-right">
                                        <i class="fa fa-plus" aria-hidden="true"></i> aggiungi
                                    </button>
                                </a>
                            <?php endif;?>
                            <br>
                            <br>
                            <div id="accordion" role="tablist" aria-multiselectable="true">

                                
                                <?php if (count($info["instruments"]) == 0): ?>
                                        <center><p style="font-weight: bold;font-size: 40px;">
                                                non ci sono strumenti.
                                        </p></center>
                                <?php
                                    endif;
                                    foreach ($info["instruments"] as $instrument):
                                        //echo "<pre>",print_r($instrument),"</pre>";
                                        
                                        include '_instrument.php';
                                    endforeach;
                                
                                ?>
                            </div>



                        </div><!--end instrument user tab-->







                    </div>

                </div>


            </div>

        </div>
    </div>







    <?php include '../include/js_scripts.php'; ?>



    <script src="../include/scripts/myjs/user.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= Google::$gmaps_key ?>&libraries=places"></script>



    <script>
<?php if (isset($_SESSION["user"]) && $_SESSION["user"]->GetId() == $info["user"]->GetId()): ?>
            $(document).ready(function () {

                var groups =<?= json_encode($info["allgroups"]); ?>;
                var images =<?= json_encode($info["photos"]); ?>;
                setVariables(groups, images);//praticamente passo le variabili delle foto e dei gruppi al file js


                initAutocomplete();
                mappa();
                displayGroups(groups);


                //centerView();//centra la view in modo che lo zoom della mappa prenda tutti i marker

            });
            $('[data-fancybox="profile"]').fancybox({
                buttons: [
                    'delete',
                    'close'
                ]
            });

<?php endif; ?>

    </script>

</body>
</html>