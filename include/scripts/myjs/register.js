$(document).ready(function () {
    initAutocomplete();

});



$('#email').on('keyup',function(){
    
   
});


var placeSearch, autocomplete;
function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete-user-edit-place')),
            {types: ['geocode', 'establishment']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
}

function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}

var response;
$.validator.addMethod("uniqueEmail", function(value, element) {
    $.ajax({
        type: "POST",
        url: "../controllers/user/checkUniqueEmail.php",
        async: false, //async perche senno la validazione termina prima che la richiesta ajax magari viene eseguita: guarda https://stackoverflow.com/questions/2628413/jquery-validator-and-a-custom-rule-that-uses-ajax per di piu
        data: {
            "checkEmail":value   
        },
        dataType: "text",
        success: function(msg){
            //se esiste l'email metti la risposta a true
            response = ( msg == 'true' ) ? true : false;
        }
    });
    return response;
});


$("#register-form").validate({
    rules: {
        email:{
            email:true,
            required: true,
            uniqueEmail: true
        },
        name:"required",
        surname:"required",
        place:"required",
        born_date:{
            required:true,
            date:true
        },
        password:{
            required:true,
            minlength:6,
        },
        password_confirmation:{
            required:true,
            equalTo: '#password'
        }
    },
    messages: {
        email: {
            email: "inserisi una email valida",
            required: "inserisci una email",
            uniqueEmail:"email gia' presa"
        },
        
        name:"inserisci nome",
        surname:"inserisci cognome",
        place:"inserisci posizione",
        born_date:{
            required:"inserisci data di nascita",
            date:"inserisci data di nascita valida"
        },
        password:{
            required:"inserisci una password",
            minlength:"password deve contenere almeno 6 caratteri"
        },
        password_confirmation:{
            required:"inserisi conferma password",
            equalTo:"le password devono coincidere"
        }
        
    },
    errorElement: "em",
    errorPlacement: function (error, element) {
        // Add the `invalid-feedback` class to the error element
        error.addClass("invalid-feedback");

        if (element.prop("type") === "checkbox") {
            error.insertAfter(element.next("label"));
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).addClass("is-valid").removeClass("is-invalid");
    }
});