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
    <title>Update Event - LocalEventFinder</title>
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

    <section class="update-event">
        <div class="container">
            <h2>Update Event</h2>
            <?php
            // Database connection details
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

            // Initialize variables for form fields
            $event_id = $event_name = $event_type = $latitude = $longitude = $schedule_date = $schedule_time = $location = $description = $image = "";

            // Process form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validate event ID
                if (isset($_POST['id']) && !empty($_POST['id'])) {
                    $event_id = $_POST['id'];

                    // Escape user inputs for security
                    $event_name = $conn->real_escape_string($_POST['event_name']);
                    $event_type = $conn->real_escape_string($_POST['event_type']);
                    $latitude = $conn->real_escape_string($_POST['latitude']);
                    $longitude = $conn->real_escape_string($_POST['longitude']);
                    $schedule_date = $conn->real_escape_string($_POST['schedule_date']);
                    $schedule_time = $conn->real_escape_string($_POST['schedule_time']);
                    $location = $conn->real_escape_string($_POST['location']);
                    $description = $conn->real_escape_string($_POST['description']);

                    // Handle image upload
                    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                        $target_dir = "";
                        $target_file = $target_dir . basename($_FILES["image"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Check if image file is a actual image or fake image
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        if ($check !== false) {
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                $image = $target_file;
                            } else {
                                echo '<p>Error uploading image.</p>';
                            }
                        } else {
                            echo '<p>File is not an image.</p>';
                        }
                    }

                    // Update event details in the database
                    $sql = "UPDATE events SET event_name='$event_name', event_type='$event_type', latitude='$latitude', longitude='$longitude', schedule_date='$schedule_date', schedule_time='$schedule_time', location='$location', description='$description'";

                    if (!empty($image)) {
                        $sql .= ", image='$image'";
                    }

                    $sql .= " WHERE id='$event_id'";

                    if ($conn->query($sql) === TRUE) {
                        echo '<p>Event updated successfully. Redirecting...</p>';
                        echo '<script>window.location.href = "list.php";</script>'; // Redirect to list.php after successful update
                        exit();
                    } else {
                        echo '<p>Error updating event: ' . $conn->error . '</p>';
                    }
                } else {
                    echo '<p>Invalid event ID</p>';
                }
            } else {
                // Fetch event details based on ID from GET parameter
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $event_id = $_GET['id'];

                    // Retrieve event details from database
                    $sql = "SELECT event_name, event_type, latitude, longitude, schedule_date, schedule_time, location, description, image FROM events WHERE id='$event_id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $event_name = $row['event_name'];
                        $event_type = $row['event_type'];
                        $latitude = $row['latitude'];
                        $longitude = $row['longitude'];
                        $schedule_date = $row['schedule_date'];
                        $schedule_time = $row['schedule_time'];
                        $location = $row['location'];
                        $description = $row['description'];
                        $image = $row['image'];
                    } else {
                        echo '<p>Event not found</p>';
                    }
                } else {
                    echo '<p>Event ID not provided</p>';
                }
            }

            // Close connection
            $conn->close();
            ?>

            <!-- Update Event Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $event_id; ?>">
                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" value="<?php echo $event_name; ?>" required><br><br>
                <label for="event_type">Event Type:</label>
                <select id="event_type" name="event_type" required>
                    <option value="Flashsale" <?php if ($event_type === 'Flashsale') echo 'selected'; ?>>Flash Sale</option>
                    <option value="Sport" <?php if ($event_type === 'Sport') echo 'selected'; ?>>Sport</option>
                    <option value="Festival" <?php if ($event_type === 'Festival') echo 'selected'; ?>>Festival</option>
                </select><br><br>
                <label for="latitude">Latitude:</label>
                <input type="text" id="latitude" name="latitude" value="<?php echo $latitude; ?>" required><br><br>
                <label for="longitude">Longitude:</label>
                <input type="text" id="longitude" name="longitude" value="<?php echo $longitude; ?>" required><br><br>
                <label for="schedule_date">Date:</label>
                <input type="date" id="schedule_date" name="schedule_date" value="<?php echo $schedule_date; ?>" required><br><br>
                <label for="schedule_time">Time:</label>
                <input type="time" id="schedule_time" name="schedule_time" value="<?php echo $schedule_time; ?>" required><br><br>
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo $location; ?>" required><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50" required><?php echo $description; ?></textarea><br><br>
                <label for="image">Image:</label>
                <input type="file" id="image" name="image"><br><br>
                <?php if ($image): ?>
                    <img src="<?php echo $image; ?>" alt="Current Image" width="200"><br><br>
                <?php endif; ?>
                <input type="submit" value="Update Event">
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
