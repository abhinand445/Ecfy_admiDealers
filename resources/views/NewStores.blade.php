<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find and Select Zone</title>
</head>
<body>

    <button onclick="getLocation()">Find My Zone</button>
    <p id="zone">Zone: Not found</p>

    <!-- Manual Zone Selection -->
    <label for="manualZone">Select Zone:</label>
    <select id="manualZone">
        <option value="none">-- Select Zone --</option>
        <option value="New York">New York</option>
        <option value="Los Angeles">Los Angeles</option>
        <option value="Chicago">Chicago</option>
        <option value="Houston">Houston</option>
        <option value="Miami">Miami</option>
    </select>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;
            getZone(lat, lng);
        }

        function getZone(lat, lng) {
            let geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyClsxlefHaPWrg0sxXMRaERr9JZozv_gwM`;

            fetch(geocodeUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "OK") {
                        let addressComponents = data.results[0].address_components;
                        let zone = "Not found";

                        addressComponents.forEach(component => {
                            if (component.types.includes("administrative_area_level_2")) {
                                zone = component.long_name;
                            }
                        });

                        document.getElementById("zone").innerText = "Zone: " + zone;
                    } else {
                        alert("Zone not found.");
                    }
                })
                .catch(error => console.log("Error fetching zone:", error));
        }

        function showError(error) {
            if (error.code === error.PERMISSION_DENIED) {
                alert("You denied location access. Please enable it in browser settings or select a zone manually.");
            }
        }

        // Handle Manual Selection
        document.getElementById("manualZone").addEventListener("change", function () {
            let selectedZone = this.value;
            if (selectedZone !== "none") {
                document.getElementById("zone").innerText = "Zone: " + selectedZone;
            }
        });
    </script>

</body>
</html>



