Map module
=====

This module makes it simple to add maps to your website. It ships with Google Maps support and is built around a driver layer, so additional providers (Mapbox, Leaflet/OpenStreetMap, etc.) can be added later without touching the rest of the module.

Just provide a latitude, longitude, and your API key to create a new map, then render it anywhere on your site with a single line of code.

If you plan to use Google Maps, please [obtain your API key](https://developers.google.com/maps/documentation/javascript/get-api-key) from Google before you get started.

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
-   **Driver-based Architecture**: Provider-specific logic is isolated behind a driver interface, so adding new map providers is a matter of dropping in a new driver class.

## Usage

There are two ways to render a map:

-   `renderById($id)` — renders a map that was created and stored in the admin panel.
-   `render(array $config)` — renders an ad-hoc map directly from a configuration array, without touching storage. Useful when another module needs to show a map based on runtime data.

Both entry points feed the same renderer and produce identical output.

### Rendering a stored map

Once you've created a map, you can render it anywhere in your templates by simply using its ID:

    <section class="py-5">
        <div class="container">
            <?= $map->renderById(1); ?>
        </div>
    </section>

### Rendering an ad-hoc map

Pass the configuration directly — no database record required:

    <?= $map->render([
        'lat' => 40.7128,
        'lng' => -74.0060,
        'zoom' => 12,
        'height' => 400,
        'api_key' => 'YOUR_GOOGLE_API_KEY',
        'markers' => [
            [
                'lat' => 40.7128,
                'lng' => -74.0060,
                'label' => 'A',
                'description' => '<p>Hello</p>',
                'popup' => true
            ]
        ]
    ]); ?>

All keys are optional except `lat`, `lng` and `api_key`. Defaults are applied for the rest (`zoom = 5`, `height = 500`, `gesture = 'auto'`, `type = 'roadmap'`, `language = current site language`).

### Supported configuration keys

| Key | Type | Default | Description |
|---|---|---|---|
| `lat` | float | `0` | Initial latitude |
| `lng` | float | `0` | Initial longitude |
| `zoom` | int | `5` | Initial zoom level |
| `height` | int | `500` | Map height in pixels |
| `api_key` | string | `''` | Credential required by the selected driver (see note below) |
| `driver` | string | `'google'` | Driver identifier |
| `type` | string | `'roadmap'` | Map type (driver-specific) |
| `gesture` | string | `'auto'` | Gesture handling mode |
| `language` | string\|null | current site language | Language code |
| `static` | bool | `false` | Disable panning and keyboard shortcuts |
| `routed` | bool | `false` | Draw a route through the markers (needs at least 2 markers) |
| `clustering` | bool | `false` | Cluster markers when they are close to each other |
| `style` | string | `''` | Custom style (JSON-encoded JS array) |
| `id` | string | auto-generated | DOM id of the container |
| `markers` | array | `[]` | List of markers (see below) |

Marker keys:

| Key | Type | Default | Description |
|---|---|---|---|
| `lat` | float | `0` | Marker latitude |
| `lng` | float | `0` | Marker longitude |
| `label` | string | `''` | Marker label |
| `icon` | string | `''` | Custom icon URL |
| `description` | string | `''` | Info window HTML |
| `animation` | bool | `false` | Enable marker animation |
| `draggable` | bool | `false` | Allow dragging the marker |
| `popup` | bool | `false` | Open the info window automatically |

## Note on `api_key`

The `api_key` field carries the credential required by the selected driver. For Google it's an API key. Other providers use the same field for whatever credential they call their own — Mapbox calls it an access token, Leaflet/OpenStreetMap needs none. The key name `api_key` is used uniformly across the module. When a driver needs more than a single credential (e.g. Mapbox also needs a style URL), the module will grow a driver-specific config bag rather than overloading `api_key`.

## Drivers

The module ships with the following drivers:

-   `google` — Google Maps

More drivers can be added by implementing `Map\Driver\DriverInterface` and registering the class in `Map\Driver\DriverRegistry`. No other file needs to change — the admin form, the service URL, the asset list, the map types, and the gesture list are all sourced from the active driver.
