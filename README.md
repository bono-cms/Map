Map module
=====

This module makes it simple to add Google Maps to your website. Just provide a latitude, longitude, and your API key to create a new map. Then, render it anywhere on your site with a single line of code!

Before you get started, please [obtain your API](https://developers.google.com/maps/documentation/javascript/get-api-key) key from Google.

## Features

-   **Easy Configuration**: Set height, latitude, longitude, zoom level, language, map type, and gesture controls with minimal setup.
-   **Custom Styling**: Fully support custom styles to match your brand or theme.
-   **Simple Marker Setup**: Add markers using just latitude and longitude.
-   **Marker Clustering**: Automatically group a large number of markers into clusters that expand on click.
-   **Marker Animations**: Add smooth animations to bring your markers to life.
-   **Marker Labels**: Display custom labels for each marker.
-   **Coordinate Inheritance**: Markers can inherit coordinates from a parent map for cleaner code and consistency.
-   **Reusable Map Icons**: Define a map icon once and reuse it across all markers.
-   **Info Windows**: Optionally attach information windows to markers for interactive content.
-   **Unlimited Maps**: Create and render as many maps as you need—no limits.
-   **Auto Language Detection**: Automatically detect and apply the user's language unless specified manually.
-   **Routed Maps**: Enable route visualization by simply checking the "Routed" option and adding markers.
-   **Static Maps**: Disable map scrolling to create fixed/static maps when needed.
-   **Address to Coordinates**: Automatically find coordinates by entering an address when creating markers.

## Usage

Once you've created a map, you can render it anywhere in your templates by simply using its ID. There's only one method you need: `renderMap($id)` — it's that easy!

### Example

Here's the basic example:

    <section class="py-5">
	    <div class="container">
	        <?= $map->renderMap(1); ?>
        </div>
    </section>
