

  document.addEventListener("DOMContentLoaded", function() {
   
    const map = L.map('map', {
        center: [-29.50, 145],
        zoom: 3.5
      });
      
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors' }).addTo(map);
      let marker;

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          latit = position.coords.latitude;
          longit = position.coords.longitude;
          // this is just a marker placed in that position
          marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
          // move the map to have the location in its center
          map.panTo(new L.LatLng(latit, longit));
      }) 
      }
      // Add the search control
const searchControl = L.Control.geocoder({
    geocoder: L.Control.Geocoder.nominatim(),
    defaultMarkGeocode: false,
}).addTo(map);


searchControl.on('markgeocode', function (e) {
    // Clear the previous marker, if it exists
    if (marker) {
        map.removeLayer(marker);
    }

    // Get the selected location information
    const location = e.geocode.center;

    // Create a marker at the selected location
    marker = L.marker(location).addTo(map);

    // You can also open a popup with additional information if needed
    marker.bindPopup(e.geocode.name).openPopup();

    // Set the map view to the selected location
    map.setView(location, 13);
    map.panTo(location);
});






  });
  