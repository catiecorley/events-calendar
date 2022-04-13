<?php

session_start();
ini_set("session.cookie_httponly", 1);
require 'mysql-connect.php';

//get event from form
$day = $_POST['event-day'];
$year = $_POST['event-year'];
$name = $_POST['event-name'];
$originalName = $_POST['event-name-original'];
$link = $_POST['event-link'];

$month = $_POST['event-month'];
$time = $_POST['event-time'];



if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}


//update table where for speicific event 
$user_uploaded = $_SESSION['user'];
$stmt = $mysqli->prepare("update events set name=?, year=?, month=?, day=?, user=?, time=?, link=? where name=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssssssss', $name, $year, $month, $day, $user_uploaded, $time, $link, $originalName); 

$stmt->execute();

$stmt->close();

header("Location: calendar.php"); #redirect to calendar



?>