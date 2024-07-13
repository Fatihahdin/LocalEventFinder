<?php
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

$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$event = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $event[] = $row;
    }
}

echo json_encode($event);

$conn->close();
?>