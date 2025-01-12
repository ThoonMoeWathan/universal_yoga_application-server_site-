<?php

include("dbconnection.php");

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $day = isset($data['day']) ? $connection->real_escape_string($data['day']) : "";
    $time = isset($data['time']) ? $connection->real_escape_string($data['time']) : "";

    if (empty($day) && empty($time)) {
        echo json_encode(["error" => "Day or Time is required"]);
        exit;
    }

    // Prepare the SQL statement
    $sql = "SELECT yc.*, ycl.*
            FROM class ycl
            JOIN course yc 
            ON ycl.courseid = yc.id
            WHERE 1=1";

    if (!empty($day)) {
        $sql .= " AND yc.day_of_week = ?";
    }
    if (!empty($time)) {
        $sql .= " AND yc.time_of_course = ?";
    }

    $stmt = $connection->prepare($sql);

    if (!empty($day) && !empty($time)) {
        $stmt->bind_param("ss", $day, $time);
    } elseif (!empty($day)) {
        $stmt->bind_param("s", $day);
    } elseif (!empty($time)) {
        $stmt->bind_param("s", $time);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $json = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $json[] = $row;
        }
        echo json_encode($json);
    } else {
        echo json_encode(["message" => "No classes found for the selected criteria."]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "Invalid Input"]);
}

$connection->close();

?>
