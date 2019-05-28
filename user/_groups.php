<div class="col-xs-12 col-sm-6 portfolio-item ">  <!-- inizio portfolio item-->
    <a class="portfolio-link" href="../group/group.php?g=<?= $group->GetId() ?>">
        <div class="portfolio-hover">
            <div class="portfolio-hover-content">
                <i class="fas fa-plus fa-3x"></i>
            </div>
        </div>
        
        <?php if(isset($g_photo)):
            $path="../photos/g_photos/".$g_photo->GetPath();
        ?>
        <div class="portfolio-image" style="background-image: url('<?=$path;?>');">
        <?php else: ?>
            <div class="portfolio-image" style="background-image: url('../photos/static/user-default.png');background-color:#009afe;background-size: 70%;background-repeat: no-repeat">
        <?php endif; ?>
            
            
           
        </div>
    </a>
    <div class="portfolio-caption">
        <h4><?= $group->GetName()?></h4>
    </div>
</div><!-- fine portfolio item-->
