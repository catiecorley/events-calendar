<!DOCTYPE html>
<head><title>Log In</title></head>
<body>


<?php
//LOG IN USER


require 'mysql-connect.php';
ini_set("session.cookie_httponly", 1);
session_start();
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));



if ($_GET['id'] == 'guest'){
    $_SESSION['user'] = 'guest';
    header("Location: calendar.php");
    exit;
}else{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("select username, password from userInfo where username=?");
    if(!$stmt){
        //USER DOES NOT EXIST
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('s', $username);

    $stmt->execute();

    $stmt->bind_result($real_username, $real_password);

    echo "<ul>\n";
    while($stmt->fetch()){
        printf("\t<li>%s %s</li>\n",
            htmlspecialchars($real_username),
            htmlspecialchars($real_password)
        );
    }
    echo "</ul>\n";

    $stmt->close();

    if($username == $real_username && password_verify($password, $real_password)){ 
        $_SESSION['user'] = $username;
        header("Location: calendar.php");
        exit;
    } else{
        header("Location: calendar-login.html");
        exit;
    }
}
?>



</body>
</html>