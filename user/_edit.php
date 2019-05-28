<form id="edit-user" action="../controllers/user/edit.php" method="post" style="display:none; width: 90%; max-width: 660px;margin-left:-5%;z-index:100" class="fancybox-content">
    <div class="form-group">
        <label for="inputnickname">email:</label>
        <input type="text" readonly class="form-control-plaintext" name="email" placeholder="<?=$_SESSION["user"]->GetEmail()?>">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputnome">nome:</label>
            <input type="text" class="form-control" name="edit_user_name" value="<?=$_SESSION["user"]->GetName()?>">
        </div>
        <div class="form-group col-md-6">
            <label for="inputcognome">cognome:</label>
            <input type="text" class="form-control" name="edit_user_surname" value="<?=$_SESSION["user"]->GetSurname()?>">
            
        </div>
    </div>
    <div class="form-group">
        <label for="inputnickname">nickname:</label>
        <input type="text" class="form-control" name="edit_user_nickname" value="<?=$_SESSION["user"]->GetNickname()?>">
    </div>
    <div class="form-group">
        <label for="indirizzo">indirizzo di recapito:</label>
        <input id="autocomplete-user-edit-place" name="edit_user_place" class="form-control" value="<?=$_SESSION["user"]->GetPlace()?>" onFocus="geolocate()" type="text"/>

    </div>
    <div class="form-group">
        <label for="datanascita">data di nascita:</label>
        <input type="date" class="form-control" name="edit_user_born_date" value="<?=$_SESSION["user"]->GetBorn_date()?>">
    </div>
    <input type="submit" class="btn btn-primary" name="submit_edit_user" value="aggiorna">

    <input type="button"class="btn btn-secondary float-right" onclick="$.fancybox.close()" value="annulla"/>




    <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close">
        <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
        <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
        </svg>
    </button>
</form>