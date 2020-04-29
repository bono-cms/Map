(function(document, JSON, google){
    // Renders a map on given HTML element
    var renderMap = function(element){
        if (element.value){
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
                // Instances of google.maps.Marker
                var clustering = [];

                for (i = 0; i < config.markers.length; i++) {
                    (function(i, clustering){
                        // Current marker
                        var current = config.markers[i];

                        var marker = new google.maps.Marker({
                            draggable: current.draggable == 1,
                            position: {
                                lat: parseFloat(current.lat),
                                lng: parseFloat(current.lng)
                            }, 
                            map: map,
                            icon : current.icon !== '' ? current.icon : null
                        });

                        // If description provided, then attach InfoWindow
                        if (current.description) {
                            var infowindow = new google.maps.InfoWindow({
                                content: (current.description)
                            });

                            marker.addListener('click', function() {
                                infowindow.open(map, marker);
                            });

                            if (current.popup == "1") {
                                infowindow.open(map, marker);
                            }
                        }

                        // Do we require clustering? If so, then push it for latter usage
                        if (config.clustering) {
                            clustering.push(marker);
                        }

                    })(i, clustering);
                }

                if (config.clustering) {
                    var markerCluster = new MarkerClusterer(map, clustering, {
                        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                    });
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
