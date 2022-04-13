<?php
// Content of database.php

//mysql username: php_user
//password: php_pass
//database: calendar
//tables: userInfo (username, password)


$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'calendar');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

?>