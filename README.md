
## Map module

This module let's you easily embed Google Maps on your site. Just create a new map providing latitude and longitude along with your API key and then with just a single line of code you can render it anywhere on your site!

Before you get started, please [obtain your API](https://developers.google.com/maps/documentation/javascript/get-api-key) key from Google.

## Features

- Google Maps
- Basic configuration (height, lat, lng, zoom, language)
- Custom styling support
- Markers. Just provide their latitude and longitude
- Shared map icons. Just define one icon only once which then to be rendered in all markers!
- Optional information window for markers
- Unlimited number of maps. Create and render them as many as you want!

## Installation

Nothing extra to do. This module can be installed just like any other Bono module.

## Usage

When you create a map, you can render it anywhere in templates provding its id. There's only one method you'll ever need - `renderMap($id)`.

### Example

    <?= $map->renderMap(1); ?>
    
    <footer>
       ...
    </footer>
