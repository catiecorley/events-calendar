<!-- page to display calendar -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="calendar-style.css">
        
        <title>Module 5 Group: Calendar</title>
       
    </head>

    <body>
        <script src="script.js"></script>
       
       <?php
         require 'mysql-connect.php';
         ini_set("session.cookie_httponly", 1);
         session_start();
         $username = $_SESSION['user'];

         
         

         if($username != 'guest'){
            echo "<h3> create a new event: </h3>
            <form name='input' action='addEvent.php' method='POST'>
                Month:  <input list='months' name='event-month'>
                <datalist id='months'>
                 <option value='January'>
                 <option value='February'>
                 <option value='March'>
                 <option value='April'>
                 <option value='May'>
                 <option value='June'>
                 <option value='July'>
                 <option value='August'>
                 <option value='September'>
                 <option value='October'>
                 <option value='November'>
                 <option value='December'>
                </datalist>
                Day: <input type='number' id = 'event-day' min='1' step='1'  max = '31' name='event-day'>
                Year: <input type='number' id = 'event-year' step='1' name='event-year'><br>
                Name: <input type='text' id = 'event-name' name='event-name'>
                Time: <input type='time' id='event-time' name='event-time' >
                Link (optional): <input type='text' id = 'event-link' name='event-link' placeholder='(include https://www.)'>

        
                 <br>
                <input type='hidden' name = 'token' value= '" . $_SESSION['token'] . "' />
                <input type='submit' id='submit-event'> 
            </form>";
         }


?>

        <br>

        <button type="submit" id='prev_month_button'> previous month </button>
        <button type="submit" id='next_month_button'> next month </button>


        <div id='month'>
           <h1 id='month-label'> current month </h1>
        </div>
    <table id='headers'>
        <tr>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
          </tr>
</table>
          <table id='calendar-table'>
          <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
     </table>
     <br>
     <div id='delete'>
         <?php 
          if($username != 'guest'){
              echo " <h3> Click an event to delete: </h3>";
          }
              ?>
         <ul id='listOfEvents'>

         </ul>
         <?php 
          if($username != 'guest'){
              echo " <h3> This month's links: </h3>";
          }
              ?>
          
         <ul id='listOfLinks'>

         </ul>

         <!-- edit event form that does not display until clicked on -->
         

         <?php

            if($username != 'guest'){
                echo "<h3> Edit an event: </h3> 
                    <form id='editEvent' action='editEvent.php' method='POST' >
                    Name of event you would like to change: <input type='text' id = 'event-name-original' name='event-name-original'>
                    <br>
                    <br>
                    New month:  <input list='months' name='event-month'>
                    <datalist id='new-months'>
                    <option value='January'>
                    <option value='February'>
                    <option value='March'>
                    <option value='April'>
                    <option value='May'>
                    <option value='June'>
                    <option value='July'>
                    <option value='August'>
                    <option value='September'>
                    <option value='October'>
                    <option value='November'>
                    <option value='December'>
                    </datalist>
                    New day: <input type='number' id = 'new-event-day' min='1' step='1'  max = '31' name='event-day'>
                    New year: <input type='number' id = 'new-event-year' step='1' name='event-year'><br>
                    New name: <input type='text' id = 'new-event-name' name='event-name'>
                    New time: <input type='time' id='new-event-time' name='event-time' >
                    Link (optional): <input type='text' id = 'new-event-link' name='event-link' placeholder='(include https://www.)'>

                    <br>
                    <input type='hidden' name = 'token' value= '" . $_SESSION['token'] . "' />

                    <input type='submit' id='submit-edit'> 
                </form>";
            }
        ?>
         
     </div>
     <br>
     
     <a href='logout.php' id='logout'> Log Out </a>
 
      
    <script>
        

        function getHolidays(year, month) {
    //    Accessing API taken from https://rapidapi.com/theapiguy/api/public-holiday/
        const data = null;
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === this.DONE) {
                console.log(this.responseText);
                var outputs = JSON.parse(this.responseText);
                console.log(outputs);
                for(var i = 0; i<outputs.length; i++){
                    console.log(outputs[i].name);
                    console.log("month: " + parseInt(JSON.stringify(outputs[i].date).substring(6,8)));
                    console.log("month input: " + month);
                    if(month == parseInt(JSON.stringify(outputs[i].date).substring(6,8)) ){
                        console.log("in if statement!!!");
                        postHoliday(outputs[i].name, parseInt(JSON.stringify(outputs[i].date).substring(9,11)));
                    }
                    
                }
            }
        });

        xhr.open("GET", "https://public-holiday.p.rapidapi.com/" + year + "/US");
        xhr.setRequestHeader("X-RapidAPI-Host", "public-holiday.p.rapidapi.com");
        xhr.setRequestHeader("X-RapidAPI-Key", "89b4ac1ff2msh6ebcf573e6f8f2cp10ed27jsn4d728932bc60");

        xhr.send(data);
    }

    function postHoliday(holidayName, holidayDay){
          var weeks = currentMonth.getWeeks();

            const table = document.getElementById("calendar-table");
            var w = 0;
            var dateRegex = /\s\d+\s/;

            for (const row of table.rows){
                var d = 0;
                var days = weeks[w].getDates();
                w++;

       
                for (const cell of row.cells){
                    console.log("postHoliday holidayDay " + holidayDay);
                    console.log("postHoliday actual cal day " + parseInt(dateRegex.exec(days[d])));
                    if(holidayDay == parseInt(dateRegex.exec(days[d]))){
                        console.log("FOUND A HOLIDAY MATCH");
                        cell.innerText += holidayName + '\n';   
                    }
                        d++;           
                }
            }
        }




        function fetchEvents(){
            var thisMonthandUser = [];
                fetch('http://ec2-52-23-252-248.compute-1.amazonaws.com/~catherinecorley/mod5/getEvents.php'
                , {    
                   method: 'GET',       
                   } 
                ).then(function(response){
                    return response.json();
                })
                .then(function(stuff){
                    console.log(JSON.stringify(stuff));
                    for(var x in stuff){
                        console.log("this stuff's name: " + stuff[x]['name']);
                        if(stuff[x]['user'] == "<?php echo $_SESSION['user'] ?>"){
                            console.log("correct user");
                            if(stuff[x]['year'] == currentMonth.year){
                                console.log("correct year");
                                if(stuff[x]['month'] == findMonth(currentMonth.month)){
                                    console.log("correct month");
                                    console.log("pushed obj: " + stuff[x]['name']);
                                    var eventObject = {"name":stuff[x]['name'], "day": stuff[x]['day'], "month": stuff[x]['month'], "time": stuff[x]['time'], "link": stuff[x]['link']};
                                    
                                    thisMonthandUser.push(eventObject);
                                    
                                    console.log("FOUND AN EVENT");

                                }
                            }
                        }
                    }
                    return thisMonthandUser;
      
                }).then(function(thisMonthandUser){
                    const table = document.getElementById("calendar-table");
                     var w = 0;
                     var weeks = currentMonth.getWeeks();
                     var dateRegex = /\s\d+\s/;

                    for (const row of table.rows){
                        var d = 0;
                        var days = weeks[w].getDates();
                        w++;
                        for (const cell of row.cells){

                            console.log("DAY: " + dateRegex.exec(days[d]) );

                            for(var x in thisMonthandUser){
                             console.log("again: " + thisMonthandUser[x]['name']);

                             if (thisMonthandUser[x]['day'] == parseInt(dateRegex.exec(days[d]))){
                                 console.log("FOUND A MATCH ON CAL");

                                 if(currentMonth.month == parseInt(JSON.stringify(days[d]).substring(6,8))-1){
                            cell.innerText += thisMonthandUser[x]['name'];
                            cell.innerText += " @ " + thisMonthandUser[x]['time'] + '\n';
                                    console.log('EVENT LINK: ' + thisMonthandUser[x]['link']);
                            if(thisMonthandUser[x]['link'] != ""){
                                console.log("GETTING IN LINK IF");
                                var ulLinks = document.getElementById('listOfLinks');
                                var listLinks = document.createElement("li")

                                var a = document.createElement('a');
                                var linkText = document.createTextNode(thisMonthandUser[x]['name']);
                                a.appendChild(linkText);
                               // a.title = "my title text";
                                a.href = thisMonthandUser[x]['link'];
                                listLinks.appendChild(a);
                                ulLinks.appendChild(listLinks);
                            }
                            var ul = document.getElementById('listOfEvents');
                            var listobj = document.createElement("li")
                            listobj.appendChild(document.createTextNode(thisMonthandUser[x]['name']));
                            ul.appendChild(listobj);
                            
                            document.getElementById("listOfEvents").addEventListener("click",function(element) {
                              
                                
                                location.replace("deleteEvent.php?name=" + element.target.innerHTML);
                                
                            });
                            
                           
                        
                        }     
                             }
                             }             
                             d++;           
                        }
                    }  
                })
                .catch(function(error){
                    console.log("found an error: " + error);
                })
                console.log("test!");
                console.log("this month and user OUTSIDE: " + thisMonthandUser);

           }

         
        var currentMonth = new Month(2022, 2);
        function findMonth(monthNumber){
            switch(monthNumber){
                case 0:
                return "January";
                break;
                case 1:
                return "February";
                break;
                case 2:
                return "March";
                break;
                case 3:
                return "April";
                break;
                case 4:
                return "May";
                break;
                case 5:
                return "June";
                break;
                case 6:
                return "July";
                break;
                case 7:
                return "August";
                break;
                case 8:
                return "September";
                break;
                case 9:
                return "October";
                break;
                case 10:
                return "November";
                break;
                case 11:
                return "December";
                break;
            }
        }

        nextMonth = document.getElementById('next_month_button');
        if(nextMonth != null){
        nextMonth.addEventListener('click', function(){
            currentMonth = currentMonth.nextMonth(); // Previous month would be currentMonth.prevMonth()

        var p = document.getElementById('listOfEvents');
        var children = p.children;
        for(var i=children.length-1; i>=0; i--){
            p.removeChild(children[i]);
        }

        var linkp = document.getElementById('listOfLinks');
        var linkchildren = linkp.children;
        for(var i=linkchildren.length-1; i>=0; i--){
            linkp.removeChild(linkchildren[i]);
        }

            updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
           
        }, false);

    }else{
        console.log("next month button is null");
    }

    prevMonth = document.getElementById('prev_month_button');
        if(prevMonth != null){
        prevMonth.addEventListener('click', function(){
            currentMonth = currentMonth.prevMonth(); // Previous month would be currentMonth.prevMonth()
            var p = document.getElementById('listOfEvents');
        var children = p.children;
        for(var i=children.length-1; i>=0; i--){
            p.removeChild(children[i]);
        }
        var linkp = document.getElementById('listOfLinks');
        var linkchildren = linkp.children;
        for(var i=linkchildren.length-1; i>=0; i--){
            linkp.removeChild(linkchildren[i]);
        }
            updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
            alert("The new month is "+currentMonth.month+" "+currentMonth.year);
        }, false);

    }else{
        console.log("prev month button is null");
    }




        function updateCalendar(){
            getHolidays(currentMonth.year, (currentMonth.month+1));
            var weeks = currentMonth.getWeeks();
            document.getElementById('month-label').innerHTML = findMonth(currentMonth.month) + " " + currentMonth.year;
            for(var w in weeks){
                var days = weeks[w].getDates();
            // days contains normal JavaScript Date objects.
    
                for(var d in days){
                    // You can see console.log() output in your JavaScript debugging tool, like Firebug,
                    // WebWit Inspector, or Dragonfly.
                    console.log(days[d].toISOString());
                }
              }
            const table = document.getElementById("calendar-table");
            var w = 0;
            var dateRegex = /\s\d+\s/;

            for (const row of table.rows){
                var d = 0;
                var days = weeks[w].getDates();
                w++;

       
                for (const cell of row.cells){
                        cell.innerText = parseInt(dateRegex.exec(days[d])) + '\n';   
                        d++;           
                }
            }
            fetchEvents();
        }
        updateCalendar();

     </script>   
        
    </body>
</html>