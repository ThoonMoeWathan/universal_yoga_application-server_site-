<?php
include("dbconnection.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$sql = "SELECT * FROM course";

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

$connection->close();
?>