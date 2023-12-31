var minRoomPrice = 0;
var maxRoomPrice = 100000;
var roomType = [];
var amenities = [];
var newLat = 0;
var newLong = 0;
let control;
let startMarker;

$(document).ready(function () {
    try {
        $("#yourPgsTable").DataTable();
    } catch (e) {}

   
});

document.addEventListener("DOMContentLoaded", function () {
    const map = L.map("map", {
        center: [-29.5, 145],
        zoom: 3.5,
    });

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);
    let marker;
    map.eachLayer(function (layer) {
        if (layer instanceof L.Control) {
            map.removeControl(layer);
        }
    });
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            newLat = position.coords.latitude;
            newLong = position.coords.longitude;
          
            marker = L.marker([
                position.coords.latitude,
                position.coords.longitude,
            ]).addTo(map);
        
                $("#latitude").val(position.coords.latitude);
                $("#longitude").val(position.coords.longitude);

       

            onSearch();

            map.panTo(new L.LatLng(newLat, newLong));
        });
    }
    // Add the search control
    const searchControl = L.Control.geocoder({
        geocoder: L.Control.Geocoder.nominatim(),
        defaultMarkGeocode: false,
    }).addTo(map);

    map.on("click", function (e) {
        if (marker) {
            map.removeLayer(marker);
        }

        if (startMarker) {
            map.removeLayer(startMarker);
        }
        if (control) {
            map.removeControl(control);
        }

        const location = e.latlng;

        marker = L.marker(location).addTo(map);

        marker.bindPopup("Selected Location").openPopup();

        map.setView(location, 18);

        try {
            newLat = location.lat;
            newLong = location.lng;
            $("#latitude").val(location.lat);
            $("#longitude").val(location.lng);
            onSearch();
        } catch (ex) {
            console.error(ex);
        }
    });

    searchControl.on("markgeocode", function (e) {
        // Clear the previous marker, if it exists
        if (marker) {
            map.removeLayer(marker);
        }
        if (startMarker) {
            map.removeLayer(startMarker);
        }

        if (control) {
            map.removeControl(control);
        }

        // Get the selected location information
        const location = e.geocode.center;

        // Create a marker at the selected location
        marker = L.marker(location).addTo(map);

        // You can also open a popup with additional information if needed
        marker.bindPopup(e.geocode.name).openPopup();

        // Set the map view to the selected location
        map.setView(location, 18);
        map.panTo(location);
    });

    try {
        var form = document.getElementById("filterForm");

        // Add an event listener for the form's submit event
        form.addEventListener("submit", function (event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            // Access the form field values
            minRoomPrice = form.elements.minRoomPrice.value;
            maxRoomPrice = form.elements.maxRoomPrice.value;
            roomType = Array.from(
                form.querySelectorAll('input[name="roomType[]"]:checked')
            ).map((input) => input.value);
            amenities = Array.from(
                form.querySelectorAll('input[name="amenities[]"]:checked')
            ).map((input) => input.value);
            onSearch();
        });
    } catch (e) {}

    // Replace with your event listener for latitude and longitude changes
    function onSearch() {
        // Make an AJAX request to fetch PGs based on the new location
        $.ajax({
            url: "/search-pgs",
            method: "GET",
            data: {
                latitude: newLat,
                longitude: newLong,
                minRoomPrice: minRoomPrice,
                maxRoomPrice: maxRoomPrice,
                roomType: roomType,
                amenities: amenities,
            },
            success: function (response) {
                // Handle the response (list of PGs)
                // You can update the UI with the retrieved PGs here
                var pgList = document.getElementById("pgList");

                // Clear any existing cards
                try {
                    pgList.innerHTML = "";
                } catch (e) {}
                // Loop through the response and create cards
                response.forEach(function (pg) {
                    // Create a Bootstrap card for each PG
                    var card = document.createElement("div");
                    card.className = "col-md-4 mb-3";

                    var cardHtml = `
          
                    <div class="card position-relative">
    <img src="storage/${pg.image1}" class="card-img-top pg-img" alt="${
                        pg.name
                    }">
   


    ${
        pg.wishlisted
            ? `<form method="POST" action="/wishlist/remove/${pg.room_id}" class="position-absolute top-0 end-0 wishlist-form">
        <input type="hidden" name="_token" value="${csrfToken}">
        <button type="submit" class="btn text-danger" >
        <i class="fa-solid fa-heart"></i>
        </button>
    </form>`
            : `<form method="POST" action="/wishlist/add/${pg.room_id}" class="position-absolute top-0 end-0 wishlist-form">
        <input type="hidden" name="_token" value="${csrfToken}">
        <button type="submit" class="btn addWishlist" value="${pg.room_id}">
        <i class="fa-regular fa-heart"></i>
        </button>
    </form>`
    }


    <div class="chips position-absolute top-0 start-0 mt-2 ms-2">
        ${
            pg.amenities
                ? pg.amenities
                      .split(",")
                      .map(
                          (amenity) => `
                        <span class="badge rounded-pill transparent-chips">${amenity}</span>
                        <br>
                    `
                      )
                      .join("")
                : ""
        }
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-between">
       
            <a href='/room/${
                pg.room_id
            }' class="nav-link"><h5 class="card-title mb-1">${pg.name}</h5></a>
            <p class="card-text">${pg.distance.toFixed(2)} km</p>
        </div>
        <div class="d-flex justify-content-between">
            <small><em>Room Type: </em> <span class="fw-bold">${
                pg.room_type
            }</span></small>
            <p class="card-text fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i> ${
                pg.room_price
            }</p>
        </div>
        <p class="card-text"><em>Contact: </em> <span class="fw-bold">${
            pg.contact_details
        }</span></p>
    </div>

    <div class="card-footer btn-group p-0" role="group" aria-label="Basic example">
        <form method="POST" action="/send/${pg.id}/${pg.room_id}" class="w-50">
            <input type="hidden" name="_token" value="${csrfToken}">
            <button type="submit" id="sendMessageButton" class="btn chat-btn w-100">
                <i class="fa-solid fa-comment"></i> Chat
            </button>
        </form>
        <button class="btn route-btn show-route-button w-50" data-start-lat="${
            pg.latitude
        }" data-start-lng="${pg.longitude}">
            <i class="fa-solid fa-route"></i> Show Route
        </button>
    </div>
</div>

            `;

                    card.innerHTML = cardHtml;
                    pgList.appendChild(card);
                    setupRouteButtonListeners();
                    //    setupAddWishlistBtnListeners()
                });
            },
            error: function (error) {
                console.error(error);
            },
        });
    }

    try {
        document
            .getElementById("pgRoute")
            .addEventListener("click", function () {
                var startLat = parseFloat(this.getAttribute("data-start-lat"));
                var startLng = parseFloat(this.getAttribute("data-start-lng"));

                // Coordinates for the starting and ending points
                var startLatLng = L.latLng(startLat, startLng);
                var endLatLng = L.latLng(newLat, newLong);
                if (startMarker) {
                    map.removeLayer(startMarker);
                }
                if (control) {
                    map.removeControl(control);
                }
                // Create a marker for the starting point
                startMarker = L.marker(startLatLng).addTo(map);

                // Create the route control
                control = L.Routing.control({
                    waypoints: [startLatLng, endLatLng],
                    routeWhileDragging: true,
                }).addTo(map);

                var myModal = new bootstrap.Modal(
                    document.getElementById("mapModal")
                );
                myModal.show();
                var backdrop = document.querySelector(".modal-backdrop");
                backdrop.parentNode.removeChild(backdrop);
            });
    } catch (e) {}

    /*   function setupAddWishlistBtnListeners() {
        document
            .querySelectorAll(".addWishlist")
            .forEach(function (addWishlistButton) {
                addWishlistButton.addEventListener("click", function (e) {
                    // Retrieve the data attributes
                      var id=this.value;
                      console.log(id)
                      e.preventDefault()
                      $.ajax({
                        url: "wishlist/add/"+id,
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token: csrfToken,
                        },
                        success: function (data) {
                            // Handle success, e.g., update the UI
                            alert('Operation successful.');
                        },
                        error: function (xhr, status, error) {
                            // Handle AJAX error
                            console.error(error);
                           
                        }
                    });

                });
            });
    }*/

    // Call the function to set up route button listeners

    function setupRouteButtonListeners() {
        document
            .querySelectorAll(".show-route-button")
            .forEach(function (routeButton) {
                routeButton.addEventListener("click", function () {
                    // Retrieve the data attributes
                    var startLat = parseFloat(
                        this.getAttribute("data-start-lat")
                    );
                    var startLng = parseFloat(
                        this.getAttribute("data-start-lng")
                    );

                    // Coordinates for the starting and ending points
                    var startLatLng = L.latLng(startLat, startLng);
                    var endLatLng = L.latLng(newLat, newLong);
                    if (startMarker) {
                        map.removeLayer(startMarker);
                    }
                    if (control) {
                        map.removeControl(control);
                    }
                    // Create a marker for the starting point
                    startMarker = L.marker(startLatLng).addTo(map);

                    // Create the route control
                    control = L.Routing.control({
                        waypoints: [startLatLng, endLatLng],
                        routeWhileDragging: true,
                    }).addTo(map);

                    // Manually open the modal
                    var myModal = new bootstrap.Modal(
                        document.getElementById("mapModal")
                    );
                    myModal.show();
                    var backdrop = document.querySelector(".modal-backdrop");
                    backdrop.parentNode.removeChild(backdrop);
                });
            });
    }

    // Call the function to set up route button listeners
});
