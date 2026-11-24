/**
 * Special handler used purely in administration panel
 * All extra handlers must be defined here
 */

// Helper class
var map = {
    google: {
        /**
         * Get coordinates from input node element
         */
        getCoordinates: function(inputElement, response){
          var autocomplete = new google.maps.places.Autocomplete(inputElement, {
            types: ['geocode']
          });

          autocomplete.setFields(['address_component', 'geometry']);
          autocomplete.addListener("place_changed", function(){
                var place = autocomplete.getPlace();
                response(place.geometry.location.lat(), place.geometry.location.lng());
          });
        }
    }
};

window.addEventListener("load", function(){
    var input = document.getElementById('autocomplete');

    // Bail out when the autocomplete input is not present on the page
    if (!input) {
        return;
    }

    // Bail out when the Places library was not loaded
    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
        return;
    }

    map.google.getCoordinates(input, function(lat, lng){
        $("[name='marker[lat]']").val(lat);
        $("[name='marker[lng]']").val(lng);
    });
});