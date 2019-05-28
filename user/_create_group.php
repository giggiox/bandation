<form id="create-group" action="../controllers/group/register.php" method="post" style="display:none; width: 90%; max-width: 660px;margin-left:-5%;" class="fancybox-content">
            <div class="form-group">            
            
                <label for="new_group_name">nome gruppo:</label>
                <input type="text" class="form-control" name="new_group_name" value="">
                
                <label for="new_group_place">indirizzo sede gruppo:</label>
                <input type="text" value="" class="form-control" name="new_group_place" id="autocomplete-register-group" onFocus="geolocate()">

            </div>
            
            <input type="submit" value="crea" class="btn btn-success">  

            <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg>
        </button>
</form>