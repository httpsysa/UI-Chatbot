<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QueriesDB";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Optional: Set character encoding to UTF-8
$conn->set_charset("utf8");
?>
