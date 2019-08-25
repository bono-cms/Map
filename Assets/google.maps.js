
(function(config){
    var element = document.getElementById(config.id);
    var map = new google.maps.Map(element, {
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

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            }
        }
    }

})(window.mapConfig);
