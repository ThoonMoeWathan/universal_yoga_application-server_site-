<?php
// Include the database connection file
include("dbconnection.php");

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Initialize the response array
$json = array();

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data) && is_array($data)) {
    foreach ($data as $item) {
        $id = $connection->real_escape_string($item['id']);
        $courseName = $connection->real_escape_string($item['courseName']);
        $day = $connection->real_escape_string($item['day']);
        $time = $connection->real_escape_string($item['time']);
        $capacity = $connection->real_escape_string($item['capacity']);
        $price = $connection->real_escape_string($item['price']);
        $type = $connection->real_escape_string($item['type']);
        $description = $connection->real_escape_string($item['description']);

        // Update or Insert logic
        $sql = "INSERT INTO course (id, course_name, day_of_week, time_of_course, capacity_of_course, price_of_course, type_of_class, description) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE course_name=?, day_of_week=?, time_of_course=?, capacity_of_course=?, price_of_course=?, type_of_class=?, description=?";
        
        $stmt = $connection->prepare($sql);
        
        // Bind parameters (remove the extra comma at the end)
        $stmt->bind_param("issssssssssssss", 
            $id, $courseName, $day, $time, $capacity, $price, $type, $description, 
            $courseName, $day, $time, $capacity, $price, $type, $description
        );

        // Execute the statement and build the response
        if ($stmt->execute()) {
            $response = array('status' => 'success', 'message' => 'Course is saved');
        } else {
            $response = array('status' => 'error', 'message' => 'Save error');
        }
        
        // Add the response to the JSON array
        array_push($json, $response);
        
        $stmt->close();
    }
} else {
    $json[] = array('status' => 'error', 'message' => 'Invalid input');
}

// Echo the complete JSON response
echo json_encode($json);

$connection->close();
?>
