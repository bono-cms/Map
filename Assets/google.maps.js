"use strict";

(function(document, console, JSON, google){
    // Inform about current API Version
    console.log('Google Maps API Version: ' + google.maps.version);

    // Renders a map on given HTML element
    var renderMap = function(element){
        if (element.value){
            // Parse map configuration of the current element
            var config = JSON.parse(element.value);

            var map = new google.maps.Map(document.getElementById(config.id), {
                zoom: parseInt(config.zoom), 
                mapTypeId: config.type ? config.type : 'roadmap',
                gestureHandling: config.gesture,
                center: {
                    lat: parseFloat(config.lat),
                    lng: parseFloat(config.lng)
                }, 
                styles: config.style ? JSON.parse(config.style) : []
            });

            // Is it static map?
            if (config.static == 1){
                map.setOptions({
                    gestureHandling: 'none',
                    keyboardShortcuts: false
                });
            }

            // Draw markers if available
            if (config.markers.length) {
                // Instances of google.maps.Marker
                var clustering = [];
                var request = {
                    travelMode: google.maps.TravelMode.DRIVING
                };

                for (var i = 0; i < config.markers.length; i++) {
                    (function(i, clustering){
                        // Current marker
                        var current = config.markers[i];
                        var hasAnimation = current.animation == '1';

                        var marker = new google.maps.Marker({
                            label: current.label !== '' ? current.label : null, 
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

                        // Is this routed map?
                        if (config.routed) {
                            if (i == 0) { // Start point
                                request.origin = marker.getPosition();
                            } else if (i == config.markers.length - 1) { // Endpoint
                                request.destination = marker.getPosition();
                            } else {
                              // The rest
                              if (!request.waypoints) {
                                request.waypoints = [];
                              }

                              request.waypoints.push({
                                location: marker.getPosition(),
                                stopover: true
                              });
                            }
                        }
                    })(i, clustering);
                }

                if (config.clustering && typeof(MarkerClusterer) !== 'undefined') {
                    var markerCluster = new MarkerClusterer(map, clustering, {
                        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                    });
                }

                // Is this routed map?
                if (config.routed) {
                    var directionsDisplay = new google.maps.DirectionsRenderer({
                        suppressMarkers: true
                    });

                    directionsDisplay.setMap(map);

                    var directionsService = new google.maps.DirectionsService();
                    directionsService.route(request, function(result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(result);
                        }
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
