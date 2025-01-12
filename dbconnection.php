<?php
//MySQLi Object-Oriented
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$servername = "localhost";

$username = "root";

$password = "";

$database = "universalyogadb";


// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully!<br>";
?>