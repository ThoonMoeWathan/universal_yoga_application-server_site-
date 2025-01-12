<?php
include("dbconnection.php");
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if data is set and valid
if (isset($data) && is_array($data)) {
    $json = array();

    foreach ($data as $item) {
        $id = $connection->real_escape_string($item['id']);
        $date = $connection->real_escape_string($item['date_of_class']);
        $teacher = $connection->real_escape_string($item['teacher']);
        $comment = $connection->real_escape_string($item['comment']);
        $courseid = $connection->real_escape_string($item['course_id']);

        // SQL with placeholders for prepared statement
        $sql = "INSERT INTO class (id, date_of_class, teacher, comment, courseid) 
                VALUES (?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE date_of_class = ?, teacher = ?, comment = ?, courseid = ?";

        $stmt = $connection->prepare($sql);

        if ($stmt === false) {
            $json[] = array('status' => 'error', 'message' => 'SQL preparation failed');
            continue;
        }

        // Bind parameters
        $stmt->bind_param("isssisssi", $id, $date, $teacher, $comment, $courseid, $date, $teacher, $comment, $courseid);

        // Execute and check for errors
        if ($stmt->execute()) {
            $json[] = array('status' => 'success', 'message' => 'Class is saved');
        } else {
            $json[] = array('status' => 'error', 'message' => 'Save error');
        }

        $stmt->close();
    }

    // Send collected responses as JSON
    echo json_encode($json);

} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid input'));
}

$connection->close();
?>
