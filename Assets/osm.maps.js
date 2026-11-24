"use strict";

(function(document, console, JSON, L){
    // Renders a map on given HTML element
    var renderMap = function(element){
        if (!element || !element.value){
            return;
        }

        // Parse map configuration of the current element
        var config = JSON.parse(element.value);

        // Create the Leaflet map without the default attribution prefix
        var map = L.map(config.id, {
            center: [parseFloat(config.lat), parseFloat(config.lng)],
            zoom: parseInt(config.zoom),
            attributionControl: false
        });

        // Add custom attribution control without Leaflet prefix (and flag icon)
        L.control.attribution({
            prefix: false
        }).addTo(map);

        // Add the OpenStreetMap tile layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Static mode: disable interactions
        if (config.static == 1) {
            map.dragging.disable();
            map.touchZoom.disable();
            map.doubleClickZoom.disable();
            map.scrollWheelZoom.disable();
            map.boxZoom.disable();
            map.keyboard.disable();
            if (map.tap) {
                map.tap.disable();
            }
        }

        // Draw markers if available
        if (config.markers.length) {
            var markers = [];
            var latLngs = [];

            for (var i = 0; i < config.markers.length; i++){
                (function(i){
                    var current = config.markers[i];
                    var lat = parseFloat(current.lat);
                    var lng = parseFloat(current.lng);
                    var latLng = [lat, lng];

                    latLngs.push(latLng);

                    var markerOptions = {
                        draggable: current.draggable == '1'
                    };

                    // Custom icon
                    if (current.icon !== '') {
                        markerOptions.icon = L.icon({
                            iconUrl: current.icon,
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34]
                        });
                    }

                    var marker = L.marker(latLng, markerOptions);

                    // Draggable marker: log new coordinates on drag end
                    if (current.draggable == '1') {
                        marker.on('dragend', function(e){
                            var pos = e.target.getLatLng();
                            console.log('New lat: ' + pos.lat);
                            console.log('New lng: ' + pos.lng);
                        });
                    }

                    // Popup (info window)
                    if (current.description) {
                        marker.bindPopup(current.description);

                        if (current.popup == '1') {
                            marker.openPopup();
                        }
                    }

                    // Marker label: Leaflet does not support labels natively.
                    // Use a tooltip bound to the marker as a reasonable equivalent.
                    if (current.label !== '') {
                        marker.bindTooltip(current.label, {
                            permanent: false,
                            direction: 'top'
                        });
                    }

                    markers.push(marker);
                })(i);
            }

            // Clustering: if enabled and the plugin is loaded
            if (config.clustering == '1' && typeof(L.markerClusterGroup) !== 'undefined') {
                var group = L.markerClusterGroup();
                for (var j = 0; j < markers.length; j++) {
                    group.addLayer(markers[j]);
                }
                map.addLayer(group);
            } else {
                // No clustering: add markers directly
                for (var k = 0; k < markers.length; k++) {
                    markers[k].addTo(map);
                }
            }

            // Routed map: Leaflet does not have built-in routing.
            // Drawing a route requires a routing plugin (e.g. Leaflet Routing Machine),
            // which is out of scope for this driver. We draw a simple polyline
            // between the markers as a visual approximation.
            if (config.routed == '1' && latLngs.length >= 2) {
                L.polyline(latLngs, {
                    color: 'blue',
                    weight: 3,
                    opacity: 0.7
                }).addTo(map);
            }

            // Fit bounds to show all markers
            if (latLngs.length > 1) {
                map.fitBounds(L.latLngBounds(latLngs), {
                    padding: [30, 30]
                });
            }
        }
    };

    var maps = document.getElementsByClassName('map-configuration-input');

    // Render maps
    for (var i = 0; i < maps.length; i++) {
        renderMap(maps[i]);
    }

})(document, console, JSON, L);