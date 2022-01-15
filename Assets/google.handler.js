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

google.maps.event.addDomListener(window, "load", function(){
    map.google.getCoordinates(document.getElementById('autocomplete'), function(lat, lng){
        $("[name='marker[lat]']").val(lat);
        $("[name='marker[lng]']").val(lng);
    });
});
