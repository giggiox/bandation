<!-- Accordion Item 1 -->
<div class="card">
    <div class="card-header" role="tab" id="<?=$instrument["instrument_info"]->GetId()?>">
        <?php if (isset($_SESSION["user"]) && $_SESSION["user"]->GetId() == $info["user"]->GetId()): ?>
            <i class="btn_modify_instrument fas fa-edit float-left" style="padding:8px;"></i>
            <i class="btn_delete_instrument fas fa-times float-left" style="padding:8px;"></i>
        <?php endif; ?>
            
            
        
        <div class="mb-0 row">
            
            <div class="col-12 no-padding accordion-head">
                
                
                
                <a data-toggle="collapse" data-parent="#accordion" href="#accordionBody<?=$instrument["instrument_info"]->GetId()?>" aria-expanded="false" aria-controls="accordionBody<?=$instrument["instrument_info"]->GetId()?>"
                   class="collapsed ">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                    <input type="hidden" id="instrument_selector_<?=$instrument["instrument_info"]->GetId()?>" value="<?=$instrument["instrument"]->GetId()?>">
                    <h3><?= $instrument["instrument"]->GetName() ?></h3>
                </a>
            </div>
        </div>
    </div>

    <div id="accordionBody<?=$instrument["instrument_info"]->GetId()?>" class="collapse" role="tabpanel" aria-labelledby="<?=$instrument["instrument_info"]->GetId()?>" aria-expanded="false">
        <div class="card-block col-12">
            <p>
                <div id="instrument_info_start_date_selector_<?=$instrument["instrument_info"]->GetId()?>">
                    data inizio: <?= date_format(date_create($instrument["instrument_info"]->GetStart_date() ), "Y M")?>
                </div>
                
                <div id="instrument_info_selector_<?=$instrument["instrument_info"]->GetId()?>">
                    <?= $instrument["instrument_info"]->GetNote() ?>
                </div>
            </p>
        </div>
    </div>
</div>
<br>