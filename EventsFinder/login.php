<?php
session_start();
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

// Initialize variables
$email = $password = $error = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to check if the user exists
    $sql = "SELECT user_id, email, password FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result === false) {
        // Error handling for query execution
        die("Error executing the query: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if ($password === $row['password']) { 
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LocalEventFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <style>
        body {
            background-image: url('img/bg.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
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
</header><br><br>

<div class="card">
    <h2>Login</h2>
    <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input class="login-button" type="submit" value="Login">
    </form>
</div>
<br><br><br>

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
