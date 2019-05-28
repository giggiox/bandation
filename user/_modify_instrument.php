<form id="modify_instrument" action="../controllers/instrument/edit.php" method="post" style="display:none; width: 90%; max-width: 660px;margin-left:-5%;" class="fancybox-content">
    <h2 class="mb-3">
    </h2>
    <p>

    </p>
    <p>

        <div class="form-group">

            <input type="hidden" name="modify_instrument_user_id" id="modify_instrument_user_id" value="">
            
            <label for="instrument_id">strumento:</label>
            <select class="form-control" name="modify_instrument_id" id="modify_instrument_id" maxlength="5">
                <?php foreach(InstrumentProvider::RetriveEntiryList() as $instrument):?>
                <option value="<?=$instrument->GetId()?>"><?=$instrument->GetName()?></option>
                <?php endforeach; ?>
            </select>
            
            <br>
            <label for="start_date">data inizio:</label>
            <input type="date" id="modify_instrument_start_date" name="modify_instrument_start_date" class="form-control">
            
            <br>
                <label for="intrument-comment">commento:</label>
                <textarea class="form-control" rows="5" id="modify_instrument_comment" name="modify_instrument_comment"></textarea>

        </div>
        
         

    </p>
    <input type="submit" value="crea" class="btn btn-success">  

            <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small float-right" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg>
        </button>
</form>


