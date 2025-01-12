<?php

include("dbconnection.php");

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

 
// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data)){
    
    if (isset($data['email'])) {
        $email = $connection->real_escape_string($data['email']);
    }
    
 
if (empty($email)) {
    echo json_encode(["error" => "email is required"]);
    exit;
}

// Prepare the SQL statement

 $sql = "SELECT ycl.*
            FROM booking yb
            JOIN class ycl 
            ON yb.class_id = ycl.id
            WHERE yb.email = ?";

$stmt = $connection->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

 // output data of each row
    $json = array();  

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
         $json[] = $row;
    }
    echo json_encode($json);
} 
else {
    echo json_encode(["message" => "No booking list for email : $email"]);
}

$stmt->close();
}
else {
        echo json_encode(["message" => "Invalid Input"]);
}


$connection->close();


?>