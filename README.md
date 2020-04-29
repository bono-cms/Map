
## Map module

This module let's you easily embed Google Maps on your site. Just create a new map providing latitude and longitude along with your API key and then with just a single line of code you can render it anywhere on your site!

Before you get started, please [obtain your API](https://developers.google.com/maps/documentation/javascript/get-api-key) key from Google.

## Features

- Google Maps
- Basic configuration (height, lat, lng, zoom, language)
- Custom styling support
- Markers. Just provide their latitude and longitude
- Marker clustering. Group large number of markers into a group that gets zoomed on click
- Coordinate inheritance. Map markers can inherit coordinates from a parent map
- Shared map icons. Just define one icon only once which then to be rendered in all markers!
- Optional information window for markers
- Unlimited number of maps. Create and render them as many as you want!
- Automatic language detection when rendering a map (if not explicitly defined in configuration)

## Installation

Nothing extra to do. This module can be installed just like any other Bono module.

## Usage

When you create a map, you can render it anywhere in templates providing its id. There's only one method you'll ever need - `renderMap($id)`.

### Example

    <?= $map->renderMap(1); ?>
    
    <footer>
       ...
    </footer>
