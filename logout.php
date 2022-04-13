<?php
ini_set("session.cookie_httponly", 1);
session_start();
//destroy current user's session to log out of the current account
session_destroy();

header("Location: calendar-login.html");
exit;

?>