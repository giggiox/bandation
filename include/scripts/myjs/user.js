//GLI SVG PRENDILI DA https://iconmonstr.com/
$.fancybox.defaults.btnTpl.delete = '<button data-fancybox-delete class="fancybox-button fancybox-button--delete" title="rimuovi imamgine">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
        '<path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 13h-12v-2h12v2z"/>' +
        '</svg>' +
        '</button>';



var groups = null;
var images = null;



function setVariables(groupss, imagess) {
    groups = groupss;
    images = imagess;
}


$('body').on('click', '[data-fancybox-delete]', function () {
    Swal.fire({
        title: 'Sei sicuro?',
        text: "cliccando elimina rimuoverai questa immagine!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si,elimina!'
    }).then((result) => {
        if (result.value) {


            //l'immagine
            //var path=$.fancybox.getInstance().group[$.fancybox.getInstance().currIndex].src;
            var index = $.fancybox.getInstance().group[$.fancybox.getInstance().currIndex].index;
            var pathImage = images;
            pathImage = pathImage[index]["path"];

            var campi = {
                path: pathImage
            }
            $.ajax({
                url: "../controllers/user/deleteImage.php",
                data: campi,
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    window.location.reload(true);
                    //console.log(data);
                },
                error: function (e) {
                    console.log(e);
                }
            });
            //console.log(path);
            //console.log(index);
            //location.reload();
        }
    })
}); //end data fancybox delete

//click add image
$('body').on('click', '#btn-add-image-user', async function () {
    const {
        value: file
    } = await Swal.fire({
        title: 'Select image',
        input: 'file',
        inputAttributes: {
            'accept': 'image/*',
            'aria-label': "aggiungi un'immagine!"
        }
    })



    if (file) {
        const reader = new FileReader
        reader.onload = (e) => {
            Swal.fire({
                title: 'descrizione:',
                imageUrl: e.target.result,
                imageAlt: 'The uploaded picture',
                input: 'text',
                showCancelButton: true,
                preConfirm: (testo) => {
                    var sendImage = new FormData();
                    sendImage.append("image", file);
                    sendImage.append("description", testo);

                    $.ajax({
                        url: "../controllers/user/addImage.php",
                        data: sendImage,
                        processData: false,
                        contentType: false,
                        type: 'POST',

                        success: function (data) {
                            window.location.reload(true)
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });

                    //console.log(testo);
                    //console.log(e.target.result);
                }
            })
        }
        reader.readAsDataURL(file)
    }

});


var placeSearch, autocomplete;

function initAutocomplete() {
    
    
    autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete-user-edit-place')), {
                types: ['geocode', 'establishment']
            });
    autocomplete.addListener('place_changed', fillInAddress);
    
    
    autocomplete = new google.maps.places.Autocomplete(
                    (document.getElementById('autocomplete-register-group')), {
                types: ['geocode', 'establishment']
            });

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




var map;
var markersArray = [];
var group_search_result = [];
var current_infowindow = null;
//var groups=null;

//var groups = @json($info["allgroups"]);
//console.log(groups);




function mappa() { //crea la mappa su coordinate dell'Italia
    var myLatLng = {
        lat: 42.504154,
        lng: 12.646361
    };
    map = new google.maps.Map(document.getElementById('map2'), {
        zoom: 5,
        center: myLatLng,
        disableDefaultUI: true
    });
    
    
    var input = document.getElementById('search_group');
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
    
    var group_number_alert=document.getElementById("found_group_number");
    map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(group_number_alert);
    
}

//groups è un oggetto formato da ["group"=>objgruppo,"photo"=>objfotogruppo]

/*$('#search-group').keyup(function () {
    var query = $('#search-group').val();
    if (query == "") {
        clearGroupsMarkers(); //prima si tolgono tutti
        displayGroups(groups); //poi si aggiungono tutti
        centerView();
        return;
    }
    group_search_result = [];
    for (var index = 0; index < groups.length; index++) {
        if (groups[index]["group"]["name"].search(query) == 0) {
            group_search_result.push(groups[index]);
        }
    }

    clearGroupsMarkers();
    displayGroups(group_search_result);
    centerView();
});*/


$('#search_group_btn').click(function(){
   var query=$('#search_group_text').val();
   if (query == "") {
        clearGroupsMarkers(); //prima si tolgono tutti
        displayGroups(groups); //poi si aggiungono tutti
        centerView();
        return;
    }
    group_search_result = [];
    for (var index = 0; index < groups.length; index++) {
        if (groups[index]["group"]["name"].search(query) == 0) {
            group_search_result.push(groups[index]);
        }
    }
    
    
    
    $('#found_group_number').html(group_search_result.length == 1 ? group_search_result.length  + " gruppo trovato" : group_search_result.length  + " gruppi trovati");
    $('#found_group_number').fadeOut(5600,function(){
        //dopo che l'animazione è finita
        $('#found_group_number').html("");
        $('#found_group_number').show();
    });
    
    
    if(group_search_result.length == 0){
        clearGroupsMarkers(); //prima si tolgono tutti
        displayGroups(groups); //poi si aggiungono tutti
        centerView();
        return;
    }
    //console.log(group_search_result.length);

    clearGroupsMarkers();
    displayGroups(group_search_result);
    centerView();
});



function displayGroups(groups) {
    //la prima volta che viene richiamata questa funzione la var groups è null. Siccome c'è da 'attingere' più volte a quella variabile con tutti i gruppi, ho fatto questo singleton che la setta alla prima volta che viene richiamata la pagina.
    /*if(groups == null){
     console.log("è null");
     groups=groupss;
     }*/

    groups.forEach(function (entry) {

        var gruppo = entry["group"];

        var latlng = {
            lat: Number(gruppo["lat"]),
            lng: Number(gruppo["lng"])
        };
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: '../photos/static/red-nodot.png',
        });
        markersArray.push(marker);


        var url = "../group/group.php?g=" + gruppo["id"];
        var photo_path = entry["photo"] == null ? '../photos/static/user-default.png' : '../photos/g_photos/' + entry["photo"]["path"];

        var contentString = "<div class='infow-evnts'>" +
                "   <div class='infow-evnts-title'>" + gruppo["name"] + "<hr>" +
                "   </div>" +
                "   <a href='" + url + "'>" +
                "       <div class='infow-groups-desc' >" +
                "           <img src='" + photo_path + "' style='background-color:#009afe'></img>" +
                "       </div>" +
                "   </a>" +
                "   <div class='infow-events-footer'>" +
                "       <hr>" +
                "       <p class='infow-events-group'>" +
                "           <i class='fas fa-users'></i> " + gruppo["name"] +
                "       </p>" +
                "   </div>" +
                "</div>";

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });


        var clicked = false;

        google.maps.event.addListener(marker, 'mouseover', function () {
            infowindow.open(map, marker);
        });
        google.maps.event.addListener(marker, 'click', function () {
            if (current_infowindow)
                current_infowindow.close();
            infowindow.open(map, marker);
            current_infowindow = infowindow;
            clicked = true;
        });
        //qua sotto ho aggiunto l'evento per qunado NB *infoindow* viene chiuso con la (x) (della GUI)  ==>l'ho fatto perche ogni tanto senno si buggava e il clicked rimaneva sempre a true poi
        google.maps.event.addListener(infowindow, 'closeclick', function () {
            clicked = false;
            //console.log(clicked);
        });
        google.maps.event.addListener(marker, 'mouseout', function () {
            //console.log(clicked);
            if (!clicked)
                infowindow.close();
        });

    });
}


function clearGroupsMarkers() {
    for (var i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
    }
    markersArray.length = 0;
}


function centerView() {
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < markersArray.length; i++) {
        bounds.extend(markersArray[i].getPosition());
    }

    map.fitBounds(bounds);
}







$("#create-group").validate({
    rules: {
        new_group_name: "required",
        new_group_place: "required"
    },
    messages: {
        new_group_name: "inserisci nome del gruppo.",
        new_group_place: "inserisci indirizzo del gruppo."
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


$("#edit-user").validate({
    rules: {
        edit_user_name: "required",
        edit_user_surname: "required",
        edit_user_place: "required",
        edit_user_born_date: "required"
    },
    messages: {
        edit_user_name: "inserisci nome.",
        edit_user_surname: "inserisci cognome.",
        edit_user_place: "inserisci indirizzo.",
        edit_user_born_date: "inserisci data di nascita."

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


$('.btn_delete_instrument').click(function () {
    var id = $(this).parent().attr('id');

    Swal.fire({
        title: 'Sei sicuro?',
        text: "cliccando elimina lo le informazioni sullo strumento verranno eliminate.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'elimina!'
    }).then((result) => {
        if (result.value) {
            //console.log(id);
            dati = {
                instrument_group_id:id
            }
            $.ajax({
               method:"POST",
               url:"../controllers/instrument/delete.php",
               data: dati,
               success: function(data){
                   window.location.reload(true)
               }
            });
            
            
        }
    })
            






});


$('.btn_modify_instrument').click(function(){
    var id = $(this).parent().attr('id');
    var instrument_id=$('#instrument_selector_'+id).val();
    var instrument_description=$('#instrument_info_selector_'+id).text().trim();
    var instrument_start_date=$('#instrument_info_start_date_selector_'+id).text().trim();
    $('#modify_instrument_user_id').val(id);
    $('#modify_instrument_start_date').val(instrument_start_date);
    $('#modify_instrument_comment').val(instrument_description);
    $('#modify_instrument_id').val(instrument_id);
    $.fancybox.open($('#modify_instrument'));
    
    //console.log(id);
    /*console.log(instrument_id);  
    console.log(instrument_description);
    console.log(instrument_start_date);*/
})

$("#modify_instrument").validate({
    rules: {
        modify_instrument_start_date: "required",
        modify_instrument_comment: "required"
    },
    messages: {
        modify_instrument_start_date: "data inizio richiesta",
        modify_instrument_comment: "commento richiesto"

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


$("#add-instrument").validate({
    rules: {
        instrument_start_date: "required",
        intrument_comment: "required"
    },
    messages: {
        instrument_start_date: "data inizio richiesta",
        intrument_comment: "commento richiesto"

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