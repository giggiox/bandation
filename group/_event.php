<div class="col-xs-12 col-sm-4">
    <div class="testimonial testimonial-gruppo" style="padding:10px;">
        <p class="description-date">
            <i class="fa fa-calendar" aria-hidden="true"></i> 
            <?= FormatEventDate($event->GetEvent_date()) ?>
            <input type="hidden" id="modify_event_date_id_<?=$event->GetId()?>" value="<?=$event->GetEvent_date()?>">
        </p>
        
        <?php if($info["privilege"] == "creator") :?>
            <div event-id="<?=$event->GetId()?>">
                <input type="hidden" value="<?=$event->GetId()?>">
                <i class="btn_modify_event fas fa-edit" style="padding:8px;"></i>
                <i class="btn_delete_event fas fa-times" style="padding:8px;"></i>
            </div>
        <?php endif; ?>
        
        <div class = "testimonial-title">
            <input type="hidden" id="modify_event_title_id_<?=$event->GetId()?>" value="<?= $event->GetTitle() ?>">
            <?= $event->GetTitle() ?>
        </div>

        <p class = "description">
            <br>
        <table style = "width:100%">
            <tr>
                <div class = "description-location">
                    <input type="hidden" id="modify_event_place_id_<?=$event->GetId()?>" value="<?= $event->GetPlace() ?>">
                    <i class = "fa fa-map-marker pre-text" aria-hidden = "true"></i> <?= $event->GetPlace() ?>
                </div>
            </tr>
            <tr>
                <div class = "description-ora-inizio">
                    <input type="hidden" id="modify_event_start_hour_id_<?=$event->GetId()?>" value="<?= FormatEventTime($event->GetStart_hour()) ?>">
                    <i class = "fas fa-clock pre-text"></i> <?= FormatEventTime($event->GetStart_hour()) ?>
                </div>
            </tr>
            <tr>
                <div class = "description-ora-fine">
                    <input type="hidden" id="modify_event_end_hour_id_<?=$event->GetId()?>" value="<?= FormatEventTime($event->GetEnd_hour()) ?>">
                    <i class = "fas fa-clock pre-text"></i> <?= FormatEventTime($event->GetEnd_hour()) ?>
                </div>
            </tr>
        </table>

        <div>
            <input type="hidden" id="modify_event_description_id_<?=$event->GetId()?>" value="<?= $event->GetDescription() ?>">
            <?= $event->GetDescription() ?>
        </div>
        </p>
    </div>
</div>