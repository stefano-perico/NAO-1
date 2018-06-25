$(document).ready(function(){

    // initialisation de la map + position de la map
    var mymap = L.map('mapid').setView([47, 1.6], 6);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 8,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiZnJvc3RlIiwiYSI6ImNqaDd3OHdtbzAwbm0ycXFsbmFtOTJidTIifQ.C6l9gAch8EEE5fxzCIF35g'
    }).addTo(mymap);

    var marker;
    // fonction click sur la map pour donner la position du clic et remplit lat et long dans form
    function onMapClick(e) {
        if (typeof (marker)==='undefined') {
            marker = new L.marker(e.latlng);
            marker.addTo(mymap)
                .bindPopup("Votre latitude et votre longitude a été renseigné en fonction de l'endroit ou vous venez de cliquer (" + e.latlng + ")").openPopup();
        }else {
            marker.setLatLng(e.latlng)
                .bindPopup("Votre latitude et votre longitude a été renseigné en fonction de l'endroit ou vous venez de cliquer (" + e.latlng + ")").openPopup();
        }
        $("#lat").val(e.latlng.lat); // a remplacer par l'id du champ latitude
        $("#long").val(e.latlng.lng); // a remplacer par l'id du champ longitude
    }

    // si localisation OK donne lat et long avec marker et remplit lat et long dans form
    function onLactionFound(e){
        if (typeof (marker)==='undefined') {
            marker = new L.marker(e.latlng);
            marker.addTo(mymap)
                .bindPopup("Votre latitude et votre longitude a été renseigné en fonction de votre emplacement GPS (" + e.latlng + ")").openPopup();
        }else {
            marker.setLatLng(e.latlng)
                .bindPopup("Votre latitude et votre longitude a été renseigné en fonction de votre emplacement GPS (" + e.latlng + ")").openPopup();
        }
        $("#observation_position_latitude").val(e.latlng.lat); // a remplacer par l'id du champ latitude
        $("#observation_position_longitude").val(e.latlng.lng); // a remplacer par l'id du champ longitude
    }

    // Message d'erreur de l'ocalisation
    function onLocationError(e) {
        alert(e.message);
    }

    // service de localisation
    $("#localisation").click(function(){
        mymap.locate({setView: true, maxZoom: 16});
    });

    mymap.on('click', onMapClick);
    mymap.on('locationfound', onLactionFound);
    mymap.on('locationerror', onLocationError);
});

$(document).ready(function() {
    $("#observation_species")
        .val("")
        .autocomplete({
            source: "{{ path('species_autocomplete') }}",
            minLength: 2,
        });
});