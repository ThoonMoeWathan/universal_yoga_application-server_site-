<?php

include("dbconnection.php");
 
header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');
 
	// Get the JSON data from the request
	$data = json_decode(file_get_contents('php://input'), true);	

if(isset($data)){
	
	 	if (isset($data['email']) && isset($data['class_id'])) {
        $email = $connection->real_escape_string($data['email']);
        $classID = $connection->real_escape_string($data['class_id']);
        
    }
 

    // Update or Insert logic
    $sql = "INSERT INTO booking (email, class_id) VALUES (?, ?)"; 
            

    $stmt = $connection->prepare($sql);

    $stmt->bind_param("si", $email, $classID);
 
    if ($stmt->execute()) {
    	
    	echo json_encode(["message" => "Booking is saved"]);
    } 
    else {
       
    	echo json_encode(["message" => "Booking Error"]);
    }
 
    $stmt->close();
    
} 

else {
    echo json_encode(["message" => "Invalid Input"]);
}
$connection->close();
?>