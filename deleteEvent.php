

<?php

ini_set("session.cookie_httponly", 1);
session_start();
require 'mysql-connect.php';

$current_user = $_SESSION['user'];

$event_name = $_GET['name']; // gets name from href


//deletes the event where the name matches the name clicked on in list
$stmt = $mysqli->prepare("delete from events where name like ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $event_name);

$stmt->execute();

$stmt->close();




header("Location: calendar.php"); 
exit;



?>
