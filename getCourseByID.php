<?php
include("dbconnection.php");
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Content-Type: application/json');
 
// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data)){
    
    if (isset($data['courseid'])) {
        $courseid  = $connection->real_escape_string($data['courseid']);
    }
    
 
if (empty($courseid)) {
    echo json_encode(["error" => "Course ID is required"]);
    exit;
}

$sql = "SELECT * FROM course where id=$courseid";

$result = $connection->query($sql);

  // output data of each row
    $json = array();    

if ($result->num_rows > 0) {   
        
  while($row = $result->fetch_assoc()) {
     //$response = array("id" => $row["id"], "name" => $row["name"], "email" => $row["email"]);

    // array_push($json,$response);
    $json[] = $row;
  }
  echo json_encode($json);
} 
else {
  $response = array("result"=>"No of rows is zero");
  array_push($json,$response);
  echo json_encode($json);
}
}
else {
        echo json_encode(["message" => "No Input"]);
}


$connection->close();
?>