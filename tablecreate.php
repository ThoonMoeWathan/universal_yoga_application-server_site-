<?php

	include("dbconnection.php");

header("Access-Control-Allow-Origin: *");

	// sql to create table
	

	$sql = "CREATE TABLE course (
			id integer PRIMARY KEY NOT NULL,
			course_name text NOT NULL,
			day_of_week text NOT NULL,
			time_of_course text NOT NULL,
			capacity_of_course text NOT NULL,
			price_of_course text NOT NULL,
			type_of_class text NOT NULL,
			description text NULL)";

	/*
	$sql = "CREATE TABLE class (
			id integer PRIMARY KEY NOT NULL, 
			date_of_class text NOT NULL,
			teacher text NOT NULL,
			comment text NULL,
			courseid integer NOT NULL
			)";

			$sql = "CREATE TABLE booking (
			id integer PRIMARY KEY AUTO_INCREMENT NOT NULL,
			email text NOT NULL,
			class_id integer NOT NULL)";
		
*/
	
if ($connection->query($sql) === TRUE) {
  echo "<p>Table is created successfully.</p>";
} 
else {
  echo "<p>Error in creating table: " . $connection->error."</p>";
}

$connection->close();

?>



