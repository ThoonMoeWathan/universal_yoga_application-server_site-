<?php

include("dbconnection.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Retrieve the JSON data sent by the React Native app
$data = json_decode(file_get_contents("php://input"), true);

if(isset($data)){

$email = $data['email'];
$cartItems = $data['cartItems'];
 
// Prepare and execute an SQL statement for each item

$flag = false;

foreach ($cartItems as $item) {
    $classID = $item['id'];   
 
    $sql = "INSERT INTO booking (email, class_id) VALUES (?, ?)"; 

    $stmt = $connection->prepare($sql);
    
    $stmt->bind_param("si", $email, $classID);
 
    if ($stmt->execute()) {
        $flag = true;
       
    } else {
        $flag= false;
        break;
    }
    $stmt->close();
}

if($flag)
    $response = ["message" => "All Bookings are saved"];
else
    $response = ["message" => "Booking Error"];

echo json_encode($response);
}
else {
    echo json_encode(["message" => "Invalid Input"]);
}
$connection->close();
?>

