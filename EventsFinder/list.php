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
    <title>List Events - LocalEventFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            width: calc(33.333% - 20px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100%;
            height: auto;
        }
        .card-content {
            padding: 15px;
        }
        .card h3 {
            margin-top: 0;
        }
        .card p {
            margin: 5px 0;
        }
        .card-actions {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
        }
        .update-btn, .delete-btn {
            padding: 10px 15px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn {
            background-color: #DC3545;
        }
        .update-btn:hover, .delete-btn:hover {
            opacity: 0.8;
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

    <section class="event-list">
        <div class="container">
            <h2>List of Events</h2>
            <?php
            // Fetch events from database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "eventfinder";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch events
            $sql = "SELECT * FROM events";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="card-container">';

                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo "<img src='img/" . $row['image'] . "' alt='Event Image'>";
                    echo '<div class="card-content">';
                    echo "<h3>" . $row['event_name'] . "</h3>";
                    echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
                    echo "<p><strong>Type:</strong> " . $row['event_type'] . "</p>";
                    echo "<p><strong>Latitude:</strong> " . $row['latitude'] . "</p>";
                    echo "<p><strong>Longitude:</strong> " . $row['longitude'] . "</p>";
                    echo "<p><strong>Date:</strong> " . $row['schedule_date'] . "</p>";
                    echo "<p><strong>Time:</strong> " . $row['schedule_time'] . "</p>";
                    echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
                    echo '</div>';
                    echo '<div class="card-actions">';
                    echo '<a href="update_event.php?id=' . $row['id'] . '"><button class="update-btn">Update</button></a>';
                    echo '<a href="delete_event.php?id=' . $row['id'] . '"><button class="delete-btn">Delete</button></a>';
                    echo '</div>';
                    echo '</div>';
                }

                echo '</div>';
            } else {
                echo "No events found.";
            }

            // Close connection
            $conn->close();
            ?>
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
</body>
</html>
