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
    <title>About Us - LocalEventFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/aboutUs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>LocalEventFinder</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php" class="active">About Us</a></li>
                    <li><a href="list.php">List Event</a></li>
                    <li><a href="add_event.php">Add Event</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="about">
        <div class="container about-content">
            <div class="about-image">
                <img src="img/event.jpeg" alt="About Local Event Finder">
            </div>
            <div class="about-text">
                <h2>About Us</h2>
                <p>LocalEvent Finder is your go-to mobile application for discovering local events such as flash sales, sports games, festivals, and more. Our mission is to connect people with exciting happenings in their area and make it easy to find and attend events. Whether you're looking for an adventure, a tour guide, or a trekking expedition, LocalEvent Finder has something for everyone.</p>
                <p>Our easy-to-use platform allows you to view event details and navigate to event locations with ease. Stay updated with the latest events and never miss out on the fun!</p>
            </div>
        </div>
    </section>

    <section class="team">
    <div class="container">
        <h2 style="text-align: center;">Meet Our Team</h2>
        <div class="card-container">
            <div class="card">
                <img src="img/fad.jpg" alt="Avatar" style="width:100%">
                <div class="container">
                <h4><b>FATIHAH DIN BINTI NASARUDDIN</b></h4> 
                <p>2022917201</p>
                <p>RCS2405A</p> 
                </div>
            </div>
            <div class="card">
                <img src="img/pijah.jpg" alt="Avatar" style="width:100%">
                <div class="container">
                <h4><b>NOR HAFFIZZAH BINTI HASBULLAH</b></h4> 
                <p>2022946941</p>
                <p>RCS2405A</p> 
                </div>
            </div>
            <div class="card">
                <img src="img/syafa.jpg" alt="Avatar" style="width:100%">
                <div class="container">
                <h4><b>NUR SYAFAWATI BINTI SABRI</b></h4> 
                <p>2022758013</p>
                <p>RCS2405A</p> 
                </div>
            </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
