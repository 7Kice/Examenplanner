<?php
session_start();
$_SESSION['somevariable'] = 'somevalue';

if(parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST) != $_SERVER["SERVER_NAME"]){
    session_destroy();
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

          selectable: false,
          select: async function (start, end, allDay) {
          const { value: formValues } = await Swal.fire({

          });

          if (formValues) 
        
        (data => {
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

      ,

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
            <button id="menu-toggle" class="btn btn-info">Login</button> <!--Login button-->
            <a class="nav-link" href="index.php" style="color: #ffffff; border-bottom: 2px solid #d8c0fd;">Examen Planner</a> <!--Home button-->
        </div> <!--End container-->
    </nav> <!--End navbar-->
    <div id="wrapper"> <!--Start wrapper-->
        <div id="sidebar-wrapper"> <!--Start sidebar wrapper-->
            <div class="container"> <!--Start container-->
                <ul class="sidebar-nav"> <!--Start sidebar-->
                <?php 
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }        
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="username">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="password">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form> 
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