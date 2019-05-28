var current_infowindow = null; // variabile globale ch epermette fi avere aperta solo una infowindow alla volta


var cliccato_eventi = false; //var che tiene conto se i bottoni sono stati gia cliccati o no
var cliccato_gruppi = false; //stessa cosa per il bottone dei gruppi
var my_marker_eventi = null; //il marker che appare sulla mia posizione quando clicco un bottone,
var my_marker_gruppi = null; //cosa analoga per il marker dei gruppi


var map; //variabile globale perchè la devo chiamare in momenti diversi dalla creazione (quando metto i marker)
var markersArray = []; //tiene gli attuali marker, serve perche poi cosi li posso togliere a mio piacimento

var draw_circle = null; //il cerchio che si trigegra quando si clicca uno dei bottoni

//console.log(document.location.hostname);


function mappa(events, groups, isGuest) { //crea la mappa su coordinate dell'Italia
    
    //console.log(events);
    var myLatLng = {
        lat: 42.504154,
        lng: 12.646361
    };
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center: myLatLng
    });

    AddEventsMarkers(events);


    //aggiungo il bottone per fare lo zoom sugli eventi
    var btn_evnt = document.getElementById("button_eventi");
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(btn_evnt);
    //aggiungo l'event listener per il bottone degli eventi
    btn_evnt.addEventListener('click', function() {

        if (cliccato_gruppi) { //devo controllare se prima è stato cliccato il bottone dei gruppi
            // QUI DOVREI TOGLIERE OGNI TIPO DI MARKER DALLA MAPPA

            draw_circle.setMap(null); //rimuovo il cerchio
            my_marker_gruppi.setMap(null); //rimuovo il marker sulla mia posizione
            map.setZoom(5); //resetto lo zoom della mappa al valore iniziale (in questo caso 5)
            cliccato_gruppi = false;
        }


        if (!cliccato_eventi) {
            clearMarkers();
            ButtonNearByEventsClick();
            AddEventsMarkers(events);
            cliccato_eventi = true;
        } else {
            draw_circle.setMap(null); //rimuovo il cerchio
            my_marker_eventi.setMap(null); //rimuovo il marker sulla mia posizione
            map.setZoom(5); //resetto lo zoom della mappa al valore iniziale (in questo caso 5)
            cliccato_eventi = false;
        }
    });


    var btn_grps = document.getElementById("button_gruppi");
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(btn_grps);

    btn_grps.addEventListener('click', function() {
        //@guest
        if(isGuest){
            Swal.fire({
                text: "Esegui il login per rendere disponibile questa funzione!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'login'
            }).then((result) => {
                if (result.value) {
                    window.location = "user/login.php";
                }
            })
        }else{
        //@else
            if (cliccato_eventi) { //se prima è stato cliccato eventi devo rimuovere cerchio e marker di posizion eattuale
                draw_circle.setMap(null); //rimuovo il cerchio
                my_marker_eventi.setMap(null); //rimuovo il marker sulla mia posizione
                map.setZoom(5); //resetto lo zoom della mappa al valore iniziale (in questo caso 5)
                cliccato_eventi = false;
            }

            if (!cliccato_gruppi) {
                clearMarkers();
                AddGroupsMarkers(groups);
                ButtonNearByGroupsClick();
                cliccato_gruppi = true;
            } else {
                draw_circle.setMap(null); //rimuovo il cerchio
                my_marker_gruppi.setMap(null); //rimuovo il marker sulla mia posizione
                map.setZoom(5); //resetto lo zoom della mappa al valore iniziale (in questo caso 5)
                cliccato_gruppi = false;
            }
            //@endguest
        }
    });

}


function ButtonNearByEventsClick() { //zooma su l'area dove sei e piazza un marker sulla tua posizione
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: 'photos/static/red-nodot.png',
                title: 'sei qui!'
            });
            my_marker_eventi = marker;

            DrawCircle(10.4, pos); //FUNCTION DrawCircle
            map.setCenter(pos);
            map.setZoom(10.4);

        }, function() {
            console.log("errore");
        });
    } else {
        // Browser doesn't support Geolocation
        console.log("il browser utilizzato non supporta la geolocalizzazione");
    }
}


function clearMarkers() {
    for (var i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
    }
    markersArray.length = 0;
}

function ButtonNearByGroupsClick() { //zooma su l'area dove sei e piazza un marker sulla tua posizione
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: 'photos/static/blue-nodot.png',
                title: 'sei qui!'
            });
            my_marker_gruppi = marker;

            DrawCircle(10.4, pos); //FUNCTION DrawCircle
            map.setCenter(pos);
            map.setZoom(10.4);

        }, function() {
            console.log("errore");
        });
    } else {
        // Browser doesn't support Geolocation
        console.log("il browser utilizzato non supporta la geolocalizzazione");
    }
}




function AddEventsMarkers(events) {

    events.forEach(function(entry) {

        //console.log(entry["event"]["lat"]);
        var latlng = {
            lat: Number(entry["event"]["lat"]),
            lng: Number(entry["event"]["lng"])
        };

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: 'photos/static/red-dot.png',
        });

        markersArray.push(marker);

        var start_hour=entry["event"]["start_hour"].split(':');
        start_hour=start_hour[0] + ":" + start_hour[1];
        
        var end_hour=entry["event"]["end_hour"].split(':');
        end_hour=end_hour[0] + ":" + end_hour[1];

        var contentString = "<div class='infow-evnts'>" +
            "	<div class='infow-evnts-date'><i class='fa fa-calendar' aria-hidden='true'></i> " + new Date(entry["event"]["event_date"]).toDateString() +
            "	</div>" +
            "	<div class='infow-evnts-title'> " + entry["event"]["title"] + "<hr>" +
            "	</div>" +
            "	<div class='infow-evnts-desc'> " + entry["event"]["description"] +
            "	</div>" +
            "	<div class='infow-events-footer'>" +
            "		<hr>" +
            "		<p class='infow-events-group'>" +
            "			<i class='fas fa-users'></i> " + entry["group"]["name"] +
            "		</p>" +
            "		<p class='infow-events-ora-inizio'>" +
            "			<i class='fas fa-clock'></i> da: " + start_hour +
            "		</p>" +
            "		<p class='infow-events-ora-fine'>" +
            "			<i class='fas fa-clock'></i> a: " + end_hour +
            "		</p>" +
            " 	</div>" +

            "</div>";

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });


        var clicked = false;

        google.maps.event.addListener(marker, 'mouseover', function() {
            infowindow.open(map, marker);
        });
        google.maps.event.addListener(marker, 'click', function() {
            if (current_infowindow)
                current_infowindow.close();
            infowindow.open(map, marker);
            current_infowindow = infowindow;
            clicked = true;
        });
        //qua sotto ho aggiunto l'evento per qunado NB *infoindow* viene chiuso con la (x) (della GUI)  ==>l'ho fatto perche ogni tanto senno si buggava e il clicked rimaneva sempre a true poi
        google.maps.event.addListener(infowindow, 'closeclick', function() {
            clicked = false;
            //console.log(clicked);
        });
        google.maps.event.addListener(marker, 'mouseout', function() {
            //console.log(clicked);
            if (!clicked)
                infowindow.close();
        });



    });

}

function AddGroupsMarkers(groups) {

    groups.forEach(function(entry) {

        var gruppo = entry["group"];
        //console.log(gruppo);

        var latlng = {
            lat: Number(gruppo["lat"]),
            lng: Number(gruppo["lng"])
        };
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: 'photos/static/blue-dot.png',
        });
        markersArray.push(marker);


        var url = "group/" + gruppo["id"];
        var photo_path = entry["photo"] == null ? 'photos/static/user-default.png' : 'storage/photos/g_photos/' + entry["photo"]["path"];

        var contentString = "<div class='infow-evnts'>" +
            "   <div class='infow-evnts-title'>" + gruppo["name"] + "<hr>" +
            "   </div>" +
            "   <a href='" + url + "'>" +
            "       <div class='infow-groups-desc' >" +
            "           <img src='" + photo_path + "'></img>" +
            "       </div>" +
            "   </a>" +
            "   <div class='infow-events-footer'>" +
            "       <hr>" +
            "       <p class='infow-events-group'>" +
            "           <i class='fas fa-users'></i> nirvana" +
            "       </p>" +
            "   </div>" +

            "</div>";

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });


        var clicked = false;

        google.maps.event.addListener(marker, 'mouseover', function() {
            infowindow.open(map, marker);
        });
        google.maps.event.addListener(marker, 'click', function() {
            if (current_infowindow)
                current_infowindow.close();
            infowindow.open(map, marker);
            current_infowindow = infowindow;
            clicked = true;
        });
        //qua sotto ho aggiunto l'evento per qunado NB *infoindow* viene chiuso con la (x) (della GUI)  ==>l'ho fatto perche ogni tanto senno si buggava e il clicked rimaneva sempre a true poi
        google.maps.event.addListener(infowindow, 'closeclick', function() {
            clicked = false;
            //console.log(clicked);
        });
        google.maps.event.addListener(marker, 'mouseout', function() {
            //console.log(clicked);
            if (!clicked)
                infowindow.close();
        });

    });



}



function DrawCircle(rad, center) { //per rimuoverlo basta fare draw_circle.setMap(null);

    rad *= 1600; // convert to meters if in miles
    if (draw_circle != null) {
        draw_circle.setMap(null);
    }
    draw_circle = new google.maps.Circle({
        center: center,
        radius: rad,
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map: map
    });
}


$('#btn-cerca-eventi').click(function() {
    $('#button_eventi_button').tooltip('show')
});

$('#btn-cerca-gruppi').click(function() {
    $('#button_gruppi_button').tooltip('show')
});


$('.slick-carousel').slick({
    slidesToShow: 3,

    centerMode: true,

    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    responsive: [
        {
            breakpoint: 1500,
            settings: {
                arrows: true,
                centerMode: false,
                centerPadding: '40px',
                slidesToShow: 3
            }
        },
        {
            breakpoint: 1000,
            settings: {
                arrows: true,
                centerMode: false,
                centerPadding: '40px',
                slidesToShow: 2
            }
        },

        {
            breakpoint: 480,
            settings: {
                arrows: true,
                centerMode: false,
                centerPadding: '40px',
                slidesToShow: 1
            }
        }

    ]
});
