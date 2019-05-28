<form id="create-event" action="../controllers/event/register.php" method="post" style="display:none; width: 90%; max-width: 660px;margin-left:-5%;" class="fancybox-content" >
    <input type="hidden" name="group" value="<?=$info["group"]->GetId()?>">


	<div class="form-group">
        <label for="event_title">titolo evento:</label>
        <input type="text" class="form-control" name="event_title" placeholder="titolo evento" value="">


        <label for="event_date">data:</label>
        <input type="date" class="form-control" name="event_date" value="">
        

        <label for="event_place">luogo svolgimento:</label>
        <input type="text" id="autocomplete-register-event" class="form-control" name="event_place" placeholder="luogo evento" onFocus="geolocate()" value="">


        <div class="form-row">
			<div class="col">
				<label for="event_start_hour">ora inizio:</label>
        		<input type="time" class="form-control" name="event_start_hour" value="">
                
			</div>
			<div class="col">
				<label for="event_end hour">ora fine:</label>
        		<input type="time" class="form-control" name="event_end_hour" value="">
               
			</div>
		</div>


        

        

        <label for="event_description">descrizione:</label>
        <textarea type="text" class="form-control" rows="3" name="event_description" placeholder="descrizione evento" value=""></textarea>

		<p></p>			
        <input type="submit" value="crea" class="btn btn-success float-left">
    </div>


    <input type="button"class="btn btn-secondary float-right" onclick="$.fancybox.close()" value="annulla"/>
    <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close">
        <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
            <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
        </svg>
    </button>
</form>