<?php
// Database configuration
$servername = "localhost"; // or 127.0.0.1
$username = "root";        // default MySQL username in XAMPP
$password = "";            // leave empty if you didn’t set a password
$database = "library_db";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
