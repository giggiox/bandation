<form id="modify-event" action="../controllers/event/edit.php" method="post" style="display:none; width: 90%; max-width: 660px;margin-left:-5%;" class="fancybox-content" >
        <input type="hidden" name="modify_event_group_id" value="<?=$info["group"]->GetId()?>">
        <input type="hidden" name="modify_event_form_event_id" id="modify_event_form_event_id">

	<div class="form-group">
        <label for="event_title">titolo evento:</label>
        <input type="text" class="form-control" id="modify_event_form_title" name="modify_event_form_title" placeholder="titolo evento" value="">


        <label for="event_date">data:</label>
        <input type="date" class="form-control" id="modify_event_form_date" name="modify_event_form_date" value="">
        

        <label for="event_place">luogo svolgimento:</label>
        <input type="text" id="autocomplete-modify-event" class="form-control" name="modify_event_form_place" placeholder="luogo evento" onFocus="geolocate()">


        <div class="form-row">
            <div class="col">
            	<label for="event_start_hour">ora inizio:</label>
                <input type="time" class="form-control" id="modify_event_form_start_hour" name="modify_event_form_start_hour" value="">
                
            </div>
            <div class="col">
		<label for="event_end hour">ora fine:</label>
        	<input type="time" class="form-control" id="modify_event_form_end_hour" name="modify_event_form_end_hour" value="">   
            </div>
        </div>


        

        

        <label for="event_description">descrizione:</label>
        <textarea type="text" class="form-control" rows="3" id="modify_event_form_description" name="modify_event_form_description" placeholder="descrizione evento" value=""></textarea>

		<p></p>			
        <input type="submit" value="aggiorna" class="btn btn-success float-left">
    </div>


    <input type="button"class="btn btn-secondary float-right" onclick="$.fancybox.close()" value="annulla"/>
    <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close">
        <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
            <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
        </svg>
    </button>
</form>