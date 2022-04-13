<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'mysql-connect.php';
       
        $json_obj = array(); 
        json_decode($json_obj, true);
        
//retreives all of the events and puts into a json object
        $stmt = $mysqli->prepare("select name, year, month, day, user, time, link from events");
        if(!$stmt){

            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->execute();

        $stmt->bind_result($event_name, $event_year, $event_month, $event_day, $event_user, $event_time, $event_link);
        while($stmt->fetch()){
            $newobj = array("name" => htmlentities($event_name), "year" => htmlentities($event_year), "month" => htmlentities($event_month), "day" => htmlentities($event_day), "user" => htmlentities($event_user), "time" => htmlentities($event_time), "link" => htmlentities($event_link)) ;
        
            array_push($json_obj, $newobj);
          
        }
       
       
      


        $stmt->close();

       
//echos the json obj created to be accessed by the fetch in calendar.php script
        $jsonData = json_encode($json_obj);
        echo $jsonData;
       
        

?>