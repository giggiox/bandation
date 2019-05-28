<form id="edit-group" action="../controllers/group/edit.php" method="post" style="display:none; width: 90%; max-width: 660px;margin-left:-5%;z-index:100" class="fancybox-content">
    <input type="hidden" name="edit_group_id" value="<?=$info["group"]->GetId()?>">
    <div class="form-group">
        <label for="inputnickname">nome gruppo:</label>
        <input type="text" class="form-control" name="edit_group_name" value="<?=$info["group"]->GetName()?>" value="">
        
    </div>

    <div class="form-group">
        <label for="indirizzo">indirizzo di recapito:</label>
        <input id="autocomplete-edit-group" name="edit_group_place" class="form-control" value="<?=$info["group"]->GetPlace()?>" onFocus="geolocate()" type="text"/>
        
    </div>
    
    <input type="submit" class="btn btn-primary" value="aggiorna">

    <input type="button"class="btn btn-secondary float-right" onclick="$.fancybox.close()" value="annulla"/>




    <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close">
        <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
            <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
        </svg>
    </button>
</form>