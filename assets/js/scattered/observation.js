$(document).ready(function(){
    var $latitude = $("#observation_position_latitude");
    var $longitude= $("#observation_position_longitude");
    var $autocompleteSpecies = $("#observation_species");
    var $messagePopup = "Votre latitude et votre longitude a été renseigné automatiquement. Votre position est: "  ;
    // initialisation de la map + position de la map
    var mymap = L.map('mapid').setView([48.857342405041436, 2.3520934581756596], 6);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 8,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiZnJvc3RlIiwiYSI6ImNqaDd3OHdtbzAwbm0ycXFsbmFtOTJidTIifQ.C6l9gAch8EEE5fxzCIF35g'
    }).addTo(mymap);

    var $marker;
    // fonction click sur la map pour donner la position du clic et remplit lat et long dans form
    function setMapMarker(e) {
        if (typeof ($marker)==='undefined') {
            $marker = new L.marker(e.latlng);
            $marker.addTo(mymap)
                .bindPopup($messagePopup + e.latlng).openPopup();
        }else {
            $marker.setLatLng(e.latlng)
                .bindPopup($messagePopup + e.latlng).openPopup();
        }
        $latitude.val(e.latlng.lat);
        $longitude.val(e.latlng.lng);
    }

    // Message d'erreur de l'ocalisation
    function onLocationError(e) {
        alert(e.message);
    }

    // service de localisation
    $("#localisation").click(function(){
        mymap.locate({setView: true, maxZoom: 16});
    });

    mymap.on('click', setMapMarker);
    mymap.on('locationfound', setMapMarker);
    mymap.on('locationerror', onLocationError);


    // autocomplete jquery ui
    $autocompleteSpecies
        .val("")
        .autocomplete({
            source: "{{ path('species_autocomplete') }}",
            minLength: 2
        });

});