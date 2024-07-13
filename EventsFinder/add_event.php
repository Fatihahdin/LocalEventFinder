<?php
session_start();
if(empty($_SESSION['login']))
{
  header("location:login.php");
}

?>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $event_name = $_POST['event_name'];
    $event_type = $_POST['event_type'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $schedule_date = date('Y-m-d', strtotime($_POST['schedule_date']));
    $schedule_time = $_POST['schedule_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Validate the data (you can add more validation as needed)
    if (!empty($event_name) && !empty($event_type) && !empty($latitude) && !empty($longitude) && !empty($schedule_date) && !empty($schedule_time) && !empty($location) && !empty($description)) {

        // Handle the file upload
        $target_dir = "";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Database connection
        $servername = "localhost"; // or your database server address
        $username = "root";
        $password = "";
        $dbname = "eventfinder";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO events (event_name, event_type, latitude, longitude, schedule_date, schedule_time, location, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssddssss", $event_name, $event_type, $latitude, $longitude, $schedule_date, $schedule_time, $location, $description, $target_file);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to list.php after successful insertion
            header("Location: list.php");
            exit(); // Ensure that no other output is sent
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event - LocalEventFinder</title>
    <link rel="stylesheet" href="css/style.css">
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

    <section class="add-event">
        <div class="container">
            <h2>Add New Event</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" required><br><br>

                <label for="location">Event Location:</label>
                <input type="text" id="location" name="location" required><br><br>
                
                <label for="event_type">Event Type:</label>
                <select id="event_type" name="event_type" required>
                    <option value="Flashsale">Flash Sale</option>
                    <option value="Sport">Sport</option>
                    <option value="Festival">Festival</option>
                </select><br><br>

                <label for="latitude">Latitude:</label>
                <input type="text" id="latitude" name="latitude" required><br><br>

                <label for="longitude">Longitude:</label>
                <input type="text" id="longitude" name="longitude" required><br><br>

                <label for="schedule_date">Schedule Date:</label>
                <input type="date" id="schedule_date" name="schedule_date" required><br><br>

                <label for="schedule_time">Schedule Time:</label>
                <input type="time" id="schedule_time" name="schedule_time" required><br><br>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea><br><br>

                <label for="image">Event Image:</label>
                <input type="file" id="image" name="image" required><br><br>

                <input type="submit" value="Add Event">
            </form>
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
