<div class="col-xs-12 col-sm-6">
    <div class="testimonial testimonial-gruppo" data-slick-index="0">
        <p class="description-date">
            <i class="fa fa-calendar" aria-hidden="true"></i> <?= FormatEventDate($event->GetEvent_date()) ?>
        </p>
        <div class="testimonial-title">
            <?= $event->GetTitle(); ?>
        </div>

        <p class="description">
            <br>
        <table style="width:100%">
            <tr>
                <div class="description-location">
                    <i class="fa fa-map-marker pre-text" aria-hidden="true"></i><?= $event->GetPlace() ?>
                </div>
            </tr>
            <tr>
                <div class="description-ora-inizio">
                    <i class="fas fa-clock pre-text"></i> inizio: <?= FormatEventTime($event->GetStart_hour()) ?>
                </div>
            </tr>
            <tr>
                <div class="description-bandname">
                    <i class="fas fa-users pre-text"></i> <?= $group->GetName() ?>
                </div>
            </tr>
            <tr>
                <div class="description-ora-fine">
                    <i class="fas fa-clock pre-text"></i> fine: <?= FormatEventTime($event->GetEnd_hour()) ?>
                </div>
            </tr>
        </table>
        
        
        
        

        <div>
            <?= $event->GetDescription() ?>
        </div>
        </p>
        <div class="testimonial-content">
            <a href="../group/group.php?g=<?= $group->GetId() ?>">
                <div class="pic">
                    <?php $path = isset($g_photo) ? "../photos/g_photos/" . $g_photo->GetPath() : "../photos/static/user-default.png"; ?>
                    <img src="<?= $path; ?>" class="" alt="" style="background-color: #009afe">
                </div>
            </a>
        </div>
    </div>
</div>

