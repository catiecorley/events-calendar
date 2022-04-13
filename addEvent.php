<?php

ini_set("session.cookie_httponly", 1);
session_start();
require 'mysql-connect.php';

//get event info from form
$day = $_POST['event-day'];
$year = $_POST['event-year'];
$name = $_POST['event-name'];
$month = $_POST['event-month'];
$time = $_POST['event-time'];

if (empty($_POST['event-link']) ){
	$link = "";
} else{
	$link =  $_POST['event-link'];

}


if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}


//update table with the new event
$user_uploaded = $_SESSION['user'];
$stmt = $mysqli->prepare("insert into events (name, year, month, day, user, time, link) values (?, ?, ?, ?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sssssss', $name, $year, $month, $day, $user_uploaded, $time, $link);

$stmt->execute();

$stmt->close();
 echo "day: " . $day . " month: " . $month . " user: " . $user_uploaded . " year: " . $year . " name: " . $name;
header("Location: calendar.php"); #redirect to calendar

?>