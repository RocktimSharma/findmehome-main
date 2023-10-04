<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- ... rest of the head content ... -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Find Me Home</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />

<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    </head>

    <style>
        body{
  margin: 0;
  padding: 0;
}

#map {
  width: 100vw;
  height: 100vh; 
}
</style>

    <body class="antialiased">
        <div id="map">
            <?php
                use Illuminate\Support\Facades\DB;
                if(DB::connection()->getPdo())
                {
                    echo "Successfully connected to the database => "
                                 .DB::connection()->getDatabaseName();
                }
            ?>
        </div>
    </body>
    <!-- ... rest of the HTML content ... -->
    <script>
const map = L.map('map', {
  center: [-29.50, 145],
  zoom: 3.5
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors' }).addTo(map);

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
    latit = position.coords.latitude;
    longit = position.coords.longitude;
    // this is just a marker placed in that position
    var abc = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
    // move the map to have the location in its center
    map.panTo(new L.LatLng(latit, longit));
}) 
}


        </script>
</html>
