<?php
$servername = "localhost";
$username = "root";
$password = "";
header("Access-Control-Allow-Origin: *");
// Create connection
$connection = new mysqli($servername, $username, $password);

// Check connection
if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}

// Create database
$sql = "CREATE DATABASE universalyogadb";
if ($connection->query($sql) === TRUE) {
  echo "<p>Database is created successfully.</p>";
} 
else {
  echo "Error in creating database: " . $connection->error;
}

$connection->close();
?>