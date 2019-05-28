<?php
require_once '../include/classes.php';
require_once '../include/functions.php';
session_start();
UserProvider::CheckRememberMe();
$FROMBASE="../";

$gid=htmlspecialchars($_GET["g"]);
$group= GroupProvider::GetEntityByPk($gid);
if(!$group){
    header("location:../404.php");
    exit();
}
$g_photos= G_photoProvider::RetriveListForGroup($group);
$users_accepted= UserProvider::GetUsersAccepted($group);


$users_a=array();
foreach($users_accepted as $user){
    $photos= U_photoProvider::RetriveEntityListForUser($user);
    $photo= isset($photos[0]) ? $photos[0] : null;
    array_push($users_a, ["user"=>$user,"photo"=>$photo]);
}


$users_request= UserProvider::GetUsersRequests($group);
$users_r=array();
foreach ($users_request as $user) {
    $photos= U_photoProvider::RetriveEntityListForUser($user);
    $photo= isset($photos[0]) ? $photos[0] : null;
    array_push($users_r, ["user"=>$user,"photo"=>$photo]);
}

//echo "<pre>",print_r($users_r),"</pre>";

$events= EventProvider::RetriveListForGroup($group);

$privilege=null;
if(isset($_SESSION["user"])){
    $privilege= UserProvider::GetUserPrivilege($group, $_SESSION["user"]);
    
}



$creator= UserProvider::GetGroupCreator($group);
$photos= U_photoProvider::RetriveEntityListForUser($creator);
$photo= isset($photos[0]) ? $photos[0] : null;
$creator_1=["user"=>$creator,"photo"=>$photo];


$info=["creator"=>$creator_1,"group"=>$group,"photos"=>$g_photos,"users_accepted"=>$users_a,"users_request"=>$users_r,"events"=>$events,"privilege"=>$privilege];



?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php include '../include/css_scripts.php'; ?>
        <link rel="stylesheet" href="../include/scripts/mycss/group.css">
        <title><?= $info["group"]->GetName() ?></title>
    </head>
    <body>
        
        <?php include '../include/navbar.php';?>
        <?php 
        if($info["privilege"]=="creator"):
            include '_create_event.php';
            include '_modify_event.php';
            include '_edit.php';
        endif;
        ?>

        <section id="tabs">
            <div class="container">


                <div class="group-userpic text-center">
                    <?php if(count($info["photos"])>0):?>
                        <?php $path="../photos/g_photos/".$info["photos"][0]->GetPath();?>
                        <a href="<?=$path?>" data-fancybox="profile" data-caption="<?=$info["photos"][0]->GetDescription()?>" id="prf-1">
                            <img src="<?=$path?>" class="img-fluid" alt="" >
                        </a>
                    <?php for($i=1;$i<count($info["photos"]); $i++): ?>
                        <a href="../photos/g_photos/<?=$info["photos"][$i]->GetPath()?>" data-fancybox="profile" data-caption="<?=$info["photos"][$i]->GetDescription()?>" id="prf-<?=$i+1?>"></a>
                    <?php endfor; ?>
                    <?php else: ?>
                        <img src="../photos/static/user-default.png" class="img-fluid" alt="" style="background-color: #009afe" >
                    <?php endif;?>

                </div>


                <?php if($info["privilege"] == "creator"): ?>
                <div class="buttons-control">
                    <i class="fas fa-plus-circle btns-controls" id="btn-add-image-group"></i>
                    <a class="btn-edit" data-fancybox="edit-group" data-src="#edit-group">
                        <i class="fas fa-edit btns-controls"></i>
                    </a>
                </div>
                <?php endif; ?>


                <h6 class="section-title h1">
                    <?=$info["group"]->GetName()?>
                </h6>

            </div><!-- container-->



            <div class="container">
                <div class="row" style="display:grid">
                    <div class="col-xs-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-eventi-tab" data-toggle="tab" href="#nav-eventi" role="tab" aria-controls="nav-eventi" aria-selected="true"  href="#eventi">Eventi</a>
                                <a class="nav-item nav-link" id="nav-membri-tab" data-toggle="tab" href="#nav-membri" role="tab" aria-controls="nav-membri" aria-selected="false">Membri</a>
                                <?php if($info["privilege"] == "creator"): ?><a class="nav-item nav-link" id="nav-richieste-tab" data-toggle="tab" href="#nav-richieste" role="tab" aria-controls="nav-richieste" aria-selected="false">Richieste <span class="badge badge-light"><?=count($info["users_request"])?></span></a> <?php endif;?>
                                <a class="nav-item nav-link" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="false">Info</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>


            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-eventi" role="tabpanel" aria-labelledby="nav-eventi-tab">
                    <div class="container">

                        <?php if($info["privilege"] == "creator"): ?>
                        
                            <a  data-fancybox="create-event" data-src="#create-event">
                                        <button type="button" class="btn btn-primary btn-circle float-right">
                                            <i class="fa fa-plus" aria-hidden="true"></i> crea evento
                                        </button>
                            </a>
                            <br><br>
                        <?php endif; ?>



                        <div class="row">
                            <?php 
                                if(count($info["events"]) == 0):
                            ?>
                            <div id="no_events_group">
                                non ci sono eventi in programma
                            </div>
                                    
                            <?php
                                endif;
                            
                                foreach($info["events"] as $event):
                                    include '_event.php';
                                endforeach;
                            ?>
                        </div><!--end row-->
                    </div><!-- end container-->

                </div><!--end nav eventi-->


                <div class="tab-pane fade" id="nav-membri" role="tabpanel" aria-labelledby="nav-membri-tab">
                    <div class="container">
                        <div class="group-members">
                            <div class="row">
                                <?php foreach($info["users_accepted"] as $user):
                                        include '_users_accepted.php';
                                    endforeach;?>
                            </div><!-- end row-->
                        </div><!-- end group member-->

                    </div><!-- end container-->
                </div><!-- end membri tab-->


                <div class="tab-pane fade" id="nav-richieste" role="tabpanel" aria-labelledby="nav-richieste-tab">
                    <div class="container">
                        <div class="row">
                            <?php if(count($info["users_request"]) == 0) :?>
                                <div id="no_request_group">
                                    al momento non ci sono richieste
                                </div>
                            <?php endif; ?>
                            <?php foreach($info["users_request"] as $user):
                                 include '_users_request.php'; 
                                 endforeach;
                            ?>
                        </div><!--end row-->
                    </div><!--end container-->
                </div> <!--end tab richieste-->


                <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                    <div class="container">
                        
                        <?php switch ($info["privilege"]):
                                
                                case "creator":                               
                                    break;
                                
                                case "refused":
                                    ?>
                                    <label class="btn btn-lg btn-danger active float-right">
                                        <i class="fas fa-times"></i> rifiutato
                                    </label>
                                    <?php 
                                    break;
                            
                            
                                case "accepted" :
                                    ?>
                                    <label class="btn btn-lg btn-success active float-right">
                                        <i class="fa fa-check"></i> iscritto
                                    </label>
                                    <?php
                                    break;
                                
                                case "request":
                                    ?>
                                    <label class="btn btn-lg btn-success float-right" style="background-color:gray">
                                        <i class="fas fa-spinner"></i> richiesta inviata
                                    </label>
                                    <?php 
                                    break;
                                
                                default :
                                    ?>
                                    <a class="btn btn-success float-right" id="btn-iscriviti" style="color:white">
                                        <i class="fas fa-plus"></i> iscriviti
                                    </a>
                                    <?php 
                            
                        endswitch;
                        ?>
                        


                        <br><br><br><br>
                        <div class="row">

                            <div class="col-xs-12 col-sm-4 group-info-created align-middle">
                                gruppo creato da:
                            </div><!--col xs 12-->


                            <div class="col-xs-12 col-sm-6">

                                <?php
                                    $user=$info["creator"];
                                    include '_users_accepted.php';
                                ?>
                                
                            </div><!--col xs 12-->
                        </div><!--end row-->

                        <div class="group-member-number">
                            creato in data:  <?= date_format(date_create($info["group"]->GetCreated_at()), "Y F") ?>
                        </div>

                        <div class="group-member-number">
                            numero membri: <?= count($info["users_accepted"]) ?>
                        </div>
                        
                        <div class="group-member-number">
                            eventi all'attivo: <?= count($info["events"]) ?>
                        </div>

                    </div><!-- end container-->

                </div><!--end tab info-->

            </div>


        </section>




        <?php include '../include/js_scripts.php'; ?>
        <script src="../include/scripts/myjs/group.js"></script>
        <script>
             <?php if($info["privilege"] == 'creator'): ?>
                $(document).ready(function(){
                    var images=<?= json_encode($info["photos"]); ?>;
                    var group=<?= json_encode($info["group"]);?>;
                    passVariables(images,group,false);
                    
                });

                $('[data-fancybox="profile"]').fancybox({
                    buttons: [
                        'delete',
                        'close'
                    ]
                });
                
            <?php 
            endif;    
            if(!isset($_SESSION["user"])):
              ?>  
                  passVariables(null,null,true);
              <?php
              elseif (is_null($info["privilege"])): ?>
                  var group=<?= json_encode($info["group"]);?>;
                  passVariables(images,group,false);
              <?php
              endif;
            ?>
            
            
            
            
        </script>
            
        
        <script src="https://maps.googleapis.com/maps/api/js?key=<?=Google::$gmaps_key?>&libraries=places"></script>
    
        
    </body>

</html>

