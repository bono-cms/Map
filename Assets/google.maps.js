(function(document, console, JSON, google){
    // Inform about current API Version
    console.log('Google Maps API Version: ' + google.maps.version);

    // Renders a map on given HTML element
    var renderMap = function(element){
        if (element.value){
            // Parse map configuration of the current element
            var config = JSON.parse(element.value);

            var map = new google.maps.Map(document.getElementById(config.id), {
                scrollwheel: false, 
                zoom: parseInt(config.zoom), 
                mapTypeId: config.type ? config.type : 'roadmap',
                gestureHandling: config.gesture,
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
                        var hasAnimation = current.animation == '1';

                        var marker = new google.maps.Marker({
                            draggable: current.draggable == 1,
                            position: {
                                lat: parseFloat(current.lat),
                                lng: parseFloat(current.lng)
                            }, 
                            map: map,
                            icon : current.icon !== '' ? current.icon : null,
                            animation : hasAnimation ? google.maps.Animation.DROP : null
                        });

                        // If description provided, then attach InfoWindow
                        if (current.description) {
                            var infoWindow = new google.maps.InfoWindow({
                                content: (current.description)
                            });

                            // Listen for close
                            infoWindow.addListener('closeclick', function(){
                                // Stop animation on infoWindow close
                                if (hasAnimation) {
                                    marker.setAnimation(null);
                                }
                            });

                            if (current.popup == "1") {
                                infoWindow.open(map, marker);
                            }
                        }

                        // Add click listener
                        marker.addListener('click', function(){
                            if (hasAnimation) {
                                if (marker.getAnimation() !== null) {
                                    marker.setAnimation(null);
                                } else {
                                    marker.setAnimation(google.maps.Animation.BOUNCE);
                                }
                            }

                            // If we have infoWindow, then show it
                            if (typeof infoWindow !== 'undefined') {
                                infoWindow.open(map, marker);
                            }
                        });

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

})(document, console, JSON, google);
