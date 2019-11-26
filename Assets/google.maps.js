(function(document, JSON, google){
    // Renders a map on given HTML element
    var renderMap = function(element){
        // Parse map configuration of the current element
        var config = JSON.parse(element.value);

        var map = new google.maps.Map(document.getElementById(config.id), {
            scrollwheel: false, 
            zoom: parseInt(config.zoom), 
            center: {
                lat: parseFloat(config.lat),
                lng: parseFloat(config.lng)
            }, 
            styles: config.style ? JSON.parse(config.style) : []
        });

        // Draw markers if available
        if (config.markers.length) {
            for (i = 0; i < config.markers.length; i++) {
                // Current marker
                var current = config.markers[i];

                var marker = new google.maps.Marker({
                    draggable: current.draggable == 1,
                    position: {
                        lat: parseFloat(current.lat),
                        lng: parseFloat(current.lng)
                    }, 
                    map: map
                });

                // If description provided, then attach InfoWindow
                if (current.description) {
                    var infowindow = new google.maps.InfoWindow({
                        content: (current.description)
                    });

                    // Show popup either on load or on click depending on configuration value
                    if (current.popup == "0") {
                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });
                    } else {
                        infowindow.open(map, marker);
                    }
                }
            }
        }
    };

    var maps = document.getElementsByClassName('map-configuration-input');

    // Render maps
    for (var index in maps) {
        var map = maps[index];
        renderMap(map);
    }

})(document, JSON, google);
