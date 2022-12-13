<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
 }
 
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: planner.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PHPEventCalender</title>
    <link rel="shotcut icon" href="./favicon.ico">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="css/style.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='js\fullcalendar\lib\main.css' rel='stylesheet' />
    <script src='js\fullcalendar\lib\main.js'></script>
    <script src="./js/sidebar.js"></script>
    <script>

document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth' ,
          height: 650,
          events: 'fetchEvents.php',

          selectable: true,
          select: async function (start, end, allDay) {
          const { value: formValues } = await Swal.fire({
            title: 'Add Event',
            html:
              '<input id="swalEvtTitle" class="swal2-input" placeholder="Examen naam">' +
              '<textarea id="swalEvtDesc" class="swal2-input" placeholder="Enter description"></textarea>' +
              '<input id="swalEvtURL" class="swal2-input" placeholder="Enter URL">' +
              '<input id="swalEvtKlas" class="swal2-input" placeholder="Klas">' +
              '<input id="swalEvtCrebo" class="swal2-input" placeholder="Crebo">'+
              '<input id="swalEvtKwalificatie" class="swal2-input" placeholder="Kwalificatie">'+
              '<input id="swalEvtCohort" class="swal2-input" placeholder="Cohort">'+
              '<input id="swalEvtBenamingeenheid" class="swal2-input" placeholder="Benamingeenheid">'+
              '<input id="swalEvtCodeeenheid" class="swal2-input" placeholder="Codeeenheid">'+
              '<input id="swalEvtAfnamevorm" class="swal2-input" placeholder="Afnamevorm">'+
              '<input id="swalEvtTijd" class="swal2-input" placeholder="Tijd">'+
              '<input id="swalEvtDuur" class="swal2-input" placeholder="Duur">'+
              '<input id="swalEvtBeoordelaar" class="swal2-input" placeholder="Beoordelaar">'+
              '<input id="swalEvtLeverancier" class="swal2-input" placeholder="Leverancier">'+
              '<input id="swalEvtToezicht" class="swal2-input" placeholder="Toezicht">'+
              '<input id="swalEvtAantal" class="swal2-input" placeholder="Aantal">'+
              '<input id="swalEvtStudentnummer" class="swal2-input" placeholder="Student nummer">'+
              '<input id="swalEvtCluster" class="swal2-input" placeholder="Cluster">'+
              '<input id="swalEvtVersie" class="swal2-input" placeholder="Versie">'+
              '<input id="swalEvtLocatie" class="swal2-input" placeholder="Locatie">'+
              '<input id="swalEvtOpmerking" class="swal2-input" placeholder="Opmerking">',

            focusConfirm: false,
            preConfirm: () => {
              return [
              document.getElementById('swalEvtTitle').value,
              document.getElementById('swalEvtDesc').value,
              document.getElementById('swalEvtURL').value,
              document.getElementById('swalEvtKlas').value,
              document.getElementById('swalEvtCrebo').value,
              document.getElementById('swalEvtKwalificatie').value,
              document.getElementById('swalEvtCohort').value,
              document.getElementById('swalEvtBenamingeenheid').value,
              document.getElementById('swalEvtCodeeenheid').value,
              document.getElementById('swalEvtAfnamevorm').value,
              document.getElementById('swalEvtTijd').value,
              document.getElementById('swalEvtDuur').value,
              document.getElementById('swalEvtBeoordelaar').value,
              document.getElementById('swalEvtLeverancier').value,
              document.getElementById('swalEvtToezicht').value,
              document.getElementById('swalEvtAantal').value,
              document.getElementById('swalEvtStudentnummer').value,
              document.getElementById('swalEvtCluster').value,
              document.getElementById('swalEvtVersie').value,
              document.getElementById('swalEvtLocatie').value,
              document.getElementById('swalEvtOpmerking').value,
              ]
            }
          });

      if (formValues) {
        // Add event
        fetch("eventHandler.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ request_type:'addEvent', start:start.startStr, end:start.endStr, event_data: formValues}),
        })
        .then(response => response.json())
        .then(data => {
          if (data.status == 1) {
          Swal.fire('Event added successfully!', '', 'success');
          } else {
          Swal.fire(data.error, '', 'error');
          }

          // Refetch events from all sources and rerender
          calendar.refetchEvents();
        })
        .catch(console.error);
        }

      },

      eventClick: function(info) {
        info.jsEvent.bordercolor ='red';

        // change the border color
        info.el.style.bordercolor = 'red';

        Swal.fire({
          title: info.event.title,
          icon: 'info',
          html:'<p>'+info.event.extendedProps.description+'</p><a href="'+info.event.url+'">Visit event page</a>',
          showCloseButton: true,
          showCancelButton: true,
          cancelButtonText: 'Close',
          confirmButtonText: 'Delete Event',
          }).then((result) => {
          if (result.isConfirmed) {
            // Delete event
            fetch("eventHandler.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ request_type:'deleteEvent', event_id: info.event.id}),
            })
            .then(response => response.json())
            .then(data => {
            if (data.status == 1) {
              Swal.fire('Event deleted successfully!', '', 'success');
            } else {
              Swal.fire(data.error, '', 'error');
            }

            // Refetch events from all sources and rerender
            calendar.refetchEvents();
            })
            .catch(console.error);
          } else {
            Swal.close();
          }
          });
        }
    });
    calendar.render();
  });
  
</script>
</head>
<body>
    <nav class="navbar navbar-expand navbar-light bg-dark sticky-top"> <!--Start navbar-->
        <div class="container"><!--Start container-->
            <button id="menu-toggle" class="btn btn-info">Logout</button> <!--Login button-->
            <a class="nav-link" href="index.php" style="color: #ffffff; border-bottom: 2px solid #d8c0fd;">Examen Planner</a> <!--Home button-->
        </div> <!--End container-->
    </nav> <!--End navbar-->
    <div id="wrapper"> <!--Start wrapper-->
        <div id="sidebar-wrapper"> <!--Start sidebar wrapper-->
            <div class="container"> <!--Start container-->
                <ul class="sidebar-nav"> <!--Start sidebar-->
                    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
                    <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
                </ul> <!--End sidebar-->
            </div> <!--End container-->
        </div> <!--End sidebar wrapper-->
        <div class="container"> <!--Start container-->
            <h1 class="display-3">Examen Planner</h1>
            <br>
            
        </div>
    <script src="./js/jquery.js"></script>
    <script src="./js/popper.js"></script>
    <script src="./js/bootstrap.js"></script>
    <script src="./js/sidebar.js"></script>
    <script src="./js/calendar.js"></script>

    <div class="input-group mb-3">
        </div>
    <div class="container">
        <div class="wrapper">
            <div id='calendar'></div>
        </div>
</body>
</html>