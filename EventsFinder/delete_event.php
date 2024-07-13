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

// Check if event ID is provided via GET parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $event_id = $_GET['id'];

    // Prepare SQL statement to delete event
    $sql = "DELETE FROM events WHERE id='$event_id'";

    if ($conn->query($sql) === TRUE) {
        // Event successfully deleted
        echo '<script>
                alert("Event deleted successfully");
                window.location.href = "list.php";
              </script>';
    } else {
        // Error deleting event
        echo '<script>
                alert("Error deleting event: ' . $conn->error . '");
                window.location.href = "list.php";
              </script>';
    }
} else {
    // Redirect if event ID is not provided
    header("Location: list.php");
    exit();
}

// Close connection
$conn->close();
?>
