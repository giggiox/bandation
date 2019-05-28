$.fancybox.defaults.btnTpl.delete = '<button data-fancybox-delete class="fancybox-button fancybox-button--delete" title="rimuovi imamgine">' +
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
    '<path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 13h-12v-2h12v2z"/>' +
    '</svg>' +
    '</button>';


var photos=null;
var group=null;
var isGuest=null;

function passVariables(photoss,groupp,guest){
  photos=photoss;
  group=groupp;
  isGuest=guest;
}

$('body').on('click', '[data-fancybox-delete]', function() {

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
            var pathImage = photos;
            pathImage = pathImage[index]["path"];

            var campi = {
                path: pathImage,
                group_id: group["id"]
            };
            console.log(campi);
            $.ajax({
                url: "../controllers/group/deleteImage.php",
                data: campi,
                type: 'POST',
                success: function(data) {
                    window.location.reload(true);
                    //console.log(data);
                },
                error: function(e) {
                    console.log(e);
                }
            });
            //console.log(path);
            //console.log(index);
            //location.reload();
        }
    })
});


$(function() {
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $('.nav-tabs a').click(function(e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop() || $('html').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });
});



$('.btn-accept-user').click(function() {
    //le 3 righe sotto sono per stoppare la propagazione degli eveti in js
    //senza queste siccome l'outer div ha un onclick appena io clicco il bottone dentro il div , si attiva il click dell'outer div-> le 3 righ sono per far si che questo non accada
    if (!e) var e = window.event;
    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();

    Swal.fire({
        title: 'Sei sicuro?',
        text: "Clicca accetta per accettare nella tua band!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'accetta!'
    }).then((result) => {
        if (result.value) {
            dati = {
                "group": group["id"],
                "user": $(this).attr("id")
            }
            $.ajax({
                url: "../controllers/group/addUserGroup.php",
                data: dati,
                type: 'POST',
                
                success: function(data) {
                    window.location.reload(true);
                },
                error: function(e) {
                    console.log(e);
                }
            })

        }
    })
});

$('.btn-deny-user').click(function() {
    if (!e) var e = window.event;
    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();

    Swal.fire({
        title: 'Sei sicuro?',
        text: "Clicca rifiuta per rifiutare questo membro della band!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'rifiuta!'
    }).then((result) => {
        if (result.value) {
            dati = {
                "group": group["id"],
                "user": $(this).attr("id")
            }
            $.ajax({
                url: "../controllers/group/denyUserGroup.php",
                data: dati,
                type: 'POST',
                success: function(data) {
                    //console.log(data);
                    window.location.reload(true);
                },
                error: function(e) {
                    console.log(e);
                }
            })

        }
    })
});



$('#btn-iscriviti').click(function() {
    if(isGuest){
      //se non sei loggato prima di iscriverti devi loggare
      Swal.fire({
          text: "Esegui il login per rendere disponibile questa funzione!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'login'
      }).then((result) => {
          if (result.value) {
              window.location = "../user/login.php";
          }
      })
    }else{
      //se sei loggato allora puoi chiedere di iscriverti
      Swal.fire({
          title: 'Sei sicuro?',
          text: "Cliccando iscriviti invierai una richiesta al gruppo.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'iscriviti!'
      }).then((result) => {
          if (result.value) {
              //in ajax mando l'id del gruppo a cui l'utente loggato si deve iscrivere
              groupie = {
                  group_id: group["id"]
              };
              $.ajax({
                  method: "POST",
                  url: "../controllers/group/subscribe.php",
                  data: groupie,
                  success: function(a) {
                      window.location.reload(true);
                  },
                  error: function(e){
                      console.log(e);
                  }
              });

          }
      })
    }

});


//click add image
$('body').on('click', '#btn-add-image-group', async function() {
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
                    sendImage.append("group", group["id"]);


                    $.ajax({
                        url: "../controllers/group/addImage.php",
                        data: sendImage,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(data) {
                            window.location.reload(true)
                        },
                        error: function(e) {
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




//per avere gli hint dell'indirizzo:

$(document).ready(function() {
    initAutocomplete();
});
var placeSearch, autocomplete;

function initAutocomplete() {
    //listener per l'edit group form
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('autocomplete-edit-group')), {
            types: ['geocode', 'establishment']
        });
    autocomplete.addListener('place_changed', fillInAddress);
    
    //listener per register event form
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('autocomplete-register-event')), {
            types: ['geocode', 'establishment']
        });
    autocomplete.addListener('place_changed', fillInAddress);
    
    //listener per modify event form
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('autocomplete-modify-event')), {
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
        navigator.geolocation.getCurrentPosition(function(position) {
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


$("#edit-group").validate({
    rules: {
        edit_group_name: "required",
        edit_group_place:"required"
    },
    messages: {
        edit_user_name: "inserisci nome.",
        edit_user_surname:"inserisci cognome."
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


$("#create-event").validate({
    rules: {
        event_title: "required",
        event_date:"required",
        event_place:"required",
        event_start_hour:"required",
        event_end_hour:"required",
        event_description:"required"
    },
    messages: {
        event_title: "inserisci titolo.",
        event_date:"inserisci data.",
        event_place:"inserisci località.",
        event_start_hour:"inserisci ora inizio.",
        event_end_hour:"inserisci ora fine.",
        event_description:"inserisci descrizione."
        
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

$('.btn_delete_event').click(function(){
    var evnt_id=$(this).parent().attr("event-id");
    //console.log(event_id);
    
    
    
    Swal.fire({
        title: 'Sei sicuro?',
        text: "cliccando elimina l'evento verrà eliminato per sempre.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'elimina!'
    }).then((result) => {
        if (result.value) {
            passabili={
                event_id:evnt_id
            };
            $.ajax({
                method:"POST",
                url:"../controllers/event/delete.php",
                data:passabili,
                success:function(data){
                    window.location.reload(true);
                }
            });  
        }
    });
    
});

$('.btn_modify_event').click(function(){
   var evnt_id=$(this).parent().attr("event-id");
   var date=$('#modify_event_date_id_'+evnt_id).val();
   var title=$('#modify_event_title_id_'+evnt_id).val();
   var place=$('#modify_event_place_id_'+evnt_id).val();
   var start_hour=$('#modify_event_start_hour_id_'+evnt_id).val();
   var end_hour=$('#modify_event_end_hour_id_'+evnt_id).val();
   var description=$('#modify_event_description_id_'+evnt_id).val();
   
   $('#modify_event_form_event_id').val(evnt_id);
   $('#modify_event_form_title').val(title);
   $('#modify_event_form_date').val(date);
   $('#autocomplete-modify-event').val(place);
   $('#modify_event_form_start_hour').val(start_hour);
   $('#modify_event_form_end_hour').val(end_hour);
   $('#modify_event_form_description').val(description);
   
   $.fancybox.open($('#modify-event'));
   
   //console.log(date + " " + title + " " + place + " " + start_hour + "  " + end_hour + " " + description);
});



$('#modify-event').validate({
    rules: {
        modify_event_form_title: "required",
        modify_event_form_date: "required",
        modify_event_form_place:"required",
        modify_event_form_start_hour:"required",
        modify_event_form_end_hour:"required",
        modify_event_form_description:"required"
    },
    messages: {
        modify_event_form_title: "inserisci titolo.",
        modify_event_form_date:"inserisci data.",
        modify_event_form_place:"inserisci località.",
        modify_event_form_start_hour:"inserisci ora inizio.",
        modify_event_form_end_hour:"inserisci ora fine.",
        modify_event_form_description:"inserisci descrizione."
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