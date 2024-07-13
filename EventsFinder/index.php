<?php
session_start();
if(empty($_SESSION['login']))
{
  header("location:login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalEventFinder</title>
    <!-- Include Google Maps API with API key -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRFaMnaqjryQ8QFV2A1naonSf86d5zgck&callback=initMap" async defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-...your-sha-here..." crossorigin="anonymous" />
    <!-- Include Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <style>
        /* Style for map container */
        #map {
            height: 400px; /* Adjust height as needed */
            width: 100%; /* Full width */
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>LocalEventFinder</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="list.php">List Event</a></li>
                    <li><a href="add_event.php">Add Event</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Discover Events Around You</h1>
            <div id="map"></div> <!-- This div is where the map will be rendered -->
            
        </div>
    </section>

    <section class="services" data-aos="fade-up">
        <div class="container">
            <h2>Our Services</h2>
            <div class="services-row">
                <div class="service-item" data-aos="fade-up" data-aos-delay="100">
                    <img src="img/sport.jpg" alt="Event Discovery" class="service-img">
                    <div class="service-content">
                        <div class="service-text">
                            <h3>Event Discovery</h3>
                            <p>Find a wide variety of local events, including flash sales, sports games, festivals, and more. Easily explore what's happening around you and choose events that match your interests.</p>
                        </div>
                    </div>
                </div>
                <div class="service-item" data-aos="fade-up" data-aos-delay="200">
                    <img src="img/fest.jpg" alt="Event Details" class="service-img">
                    <div class="service-content">
                        <div class="service-text">
                            <h3>Event Details</h3>
                            <p>Get comprehensive information about events, including schedules, locations, ticket prices, and more. Our platform provides all the details you need to make informed decisions about attending events.</p>
                        </div>
                    </div>
                </div>
                <div class="service-item" data-aos="fade-up" data-aos-delay="300">
                    <img src="img/event2.png" alt="Navigation Assistance" class="service-img">
                    <div class="service-content">
                        <div class="service-text">
                            <h3>Navigation Assistance</h3>
                            <p>Use our integrated map services to easily navigate to event locations. We provide step-by-step directions to ensure you arrive at your events without any hassle.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about">
        <div class="container about-content">
            <div class="about-text">
                <h2>About Us</h2>
                <img src="img/event.jpeg" alt="About Local Event Finder">
                <p>LocalEvent Finder is your go-to mobile application for discovering local events such as flash sales, sports games, festivals, and more. Our mission is to connect people with exciting happenings in their area and make it easy to find and attend events. Whether you're looking for an adventure, a tour guide, or a trekking expedition, LocalEvent Finder has something for everyone.</p>
                <p>Our easy-to-use platform allows you to view event details and navigate to event locations with ease. Stay updated with the latest events and never miss out on the fun!</p>
                <button class="read-more-button" onclick="window.location.href='about.php'">Read More</button><br><br>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-content">
            <div class="footer-logo">
                <h2>Event Finder</h2>
                <p>"Connecting you with local events and activities."</p>
            </div>
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p>Duplex Office Plaza Azalea, Persiaran Bandaraya<br>
                    Section 14, 40000 Shah Alam, Selangor Darul Ehsan<br>
                Malaysia</p>
                <p>Phone: +123-456-7890<br>
                Email: admin@example.com</p>
                <p>&copy; 2024 Event Finder. All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize the map
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 6.45, lng: 100.2796 }, // Default center
                zoom: 15
            });

            // Use Google Maps Geocoding API to get coordinates based on location name
            var geocoder = new google.maps.Geocoder();
            var mapMarkers = []; // Array to store markers

            // Function to show location on the map
            window.showLocation = function (locationName, travelName) {
                geocoder.geocode({ 'address': locationName }, function (results, status) {
                    if (status === 'OK') {
                        var location = results[0].geometry.location;
                        map.setCenter(location);
                        mapMarkers.forEach(marker => marker.setMap(null));

                        var marker = new google.maps.Marker({
                            map: map,
                            position: location,
                            title: travelName + ' - ' + locationName
                        });
                        mapMarkers.push(marker);

                        var contentString = '<div style="max-width: 150px; padding: 8px; background-color: #f8f8f8; border: 1px solid #ddd; border-radius: 4px; text-align: center;">' +
                            '<h3 style="margin: 0;">' + travelName + '</h3>' +
                            '<p style="margin: 0;">' + locationName + '</p>' +
                            '</div>';

                        var infoWindow = new google.maps.InfoWindow({
                            content: contentString
                        });
                        infoWindow.open(map, marker);
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            };
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
