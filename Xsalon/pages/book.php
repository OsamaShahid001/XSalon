<?php
require "../function/connection.php";
session_start();
if ($_SESSION["user"] == null) {
    header('location: ../login/login.php');
}
?>
<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: ../index.php");
}
$user = $_SESSION['user'];
$id = $_SESSION['id'];

$query = "SELECT * FROM `users` where `id` = '$id'";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $email = $row[2];
    $img = $row[4];
}
?>
<!-- ------------------------function--------------------- -->
<?php
$date = date('Y-m-d');
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}

$existingTimes = [];
$query = "SELECT time FROM `bookings` WHERE `date` = '$date' ";
$result = mysqli_query($con, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $existingTimes[] = $row['time'];
    }
}

function get_times($default = '12:00', $interval = '+60 minutes', $existingTimes = [])
{
    $output = '';
    $current = strtotime('12:00');

    // Set the end time to 6:00 PM
    $end = strtotime('18:00');

    // Check if $existingTimes array is empty
    if (empty($existingTimes)) {
        // Default behavior when $existingTimes is empty
        while ($current <= $end) {
            $time = date('g:i', $current);
            $color_avail = ($time) ? ' style="color: green;"' : '';
            $sel = ($time == $default) ? ' selected' : '';
            $output .= "<option value=\"{$time}\"{$sel}{$color_avail}>" . date('g.i A', $current) . '</option>';
            $current = strtotime($interval, $current);
        }
    } else {
        // Behavior when $existingTimes has values
        while ($current <= $end) {
            $time = date('g:i', $current);
            $sel = ($time == $default) ? ' selected' : '';
            $isBooked = in_array($time, $existingTimes);
            $disabled = ($isBooked) ? ' disabled' : '';
            $color = ($isBooked) ? ' style="color: red;"' : '';
            $color_avail = ($time) ? ' style="color: green;"' : '';
            $output .= "<option value=\"{$time}\"{$sel}{$disabled}{$color}{$color_avail}>" . date('g.i A', $current) . '</option>';
            $current = strtotime($interval, $current);
        }
    }

    return $output;
}

$dropdown = get_times('12:00', '+60 minutes', $existingTimes);

// ----------------- Booking insert----------------
$Error = null;
$Error1 = null;
$Booked = null;
$pop_up = "hidden";

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']) ?? null;
    $services = $_POST['services'];
    $time = $_POST['time'] ?? null;

    if($time == null){
       $Error = "<div class='alert alert-danger'>Please Select Time!</div>";
    
    }if($name == null){
        $Error1 = "<div class='alert alert-danger'>Please Enter Your Name!</div>";
    
    }
     elseif(!empty($time)AND!empty($name)){

    $query = "SELECT * FROM `bookings` Where `date` = '$date' AND `name` = '$name' AND `services` = '$services'";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result);
    if($count > 0){
        $Booked = "<div class='alert alert-danger'>Already Booked</div>";
    }else{
            if (isset($_POST['submit'])) {

        $services = $_POST['services'];
        $price = 0;
        switch ($services) {
            case "Hair Cut":
                $price = 9.99;
                break;
            case "Hair Wash":
                $price = 10.99;
                break;
            case "Hair Color":
                $price = 11.99;
                break;
            case "Hair Shave":
                $price = 12.99;
                break;
            case "Hair Straight":
                $price = 13.99;
                break;
            case "Facial":
                $price = 14.99;
                break;
            case "Shampoo":
                $price = 15.99;
                break;
            case "Beard Trim":
                $price = 16.99;
                break;
            case "Beard Shave":
                $price = 17.99;
                break;
            case "Wedding Cut":
                $price = 18.99;
                break;
            case "Clean Up":
                $price = 19.99;
                break;
            case "Massage":
                $price = 20.99;
                break;
        }

        // echo "booking id:" . rand(1, 1000) . "<br>" . $services . "= $" . $price;
    }
    $query = "INSERT INTO `bookings`(`date`, `time`, `name`, `email`, `services`, `price`, `user_id`) VALUES ('$date','$time','$name','$email','$services','$price','$id')";
    $result = mysqli_query($con,$query);
    if($result){
        $Booked = "<div class='alert alert-success'>Booked Appointment Successfully</div>";
        $pop_up = "";
    }   
}}}

?>

<?php

    if (isset($_POST['back'])) {
        header("Location: booking.php");
    }
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xsalon-Home</title>
    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">


    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>
<style>

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
            overflow: hidden;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            text-align: end;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }


        .modal-content button {
            background-color: #03b6fc !important;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;

        }

        h1 {
            text-align: center;
        }
</style>
<body>


    <!-- Top Bar Start-->

    <div class="top-bar d-none d-md-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="top-bar-left">
                    <div class="text">
                            <h2>12:00 - 8:00</h2>
                            <p>Opening Hour Mon - Sun</p>
                        </div>
                        <div class="text">
                            <h2>+123 456 7890</h2>
                            <p>Call Us For Appointment</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="top-bar-right">
                        <div class="social">
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                            <a href=""><i class="fab fa-linkedin-in"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Bar End -->

    <!-- Nav Bar Start -->
    <div class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">Barber <span>X</span></a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto">
                    <a href="home.php" class="nav-item nav-link ">Home</a>                    
                    <a href="booking.php" class="nav-item nav-link active">Booking</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="service.php" class="nav-item nav-link">Service</a>
                    <a href="portfolio.php" class="nav-item nav-link">Gallery</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                    <?php
                    if(isset($_SESSION['user'])){
                        $dates = date('Y-m-d');
                        $query = "SELECT * FROM `bookings` WHERE `user_id`='$id' AND (`date`<'$dates' AND feedback = '')";
                        $result = mysqli_query($con, $query);
                        $count = mysqli_num_rows($result);
                        if($count > 0){
                           echo '<a href="user profile/feed.php" class="nav-item nav-link">Feedback</a>';
                        }}
                    ?>
                    <div class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../<?=$img?>" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>

                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item"><?php echo $_SESSION['user']; ?></a></li>
                            <li><a class="dropdown-item" href="user profile/profile.php">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form method="post">
                                <li><button type="submit" class='dropdown-item' name="logout">Logout</button></li>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Nav Bar End -->

    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>BOOKING</h2>
                </div>
                <div class="col-12">
                    <a href="home.php">Home</a>
                    <a href="booking.php">booking</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="container">
        <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1>
        <hr>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                <?php echo isset($msg) ? $msg : ''; ?>
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                        <?=$Error1?>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="" disabled class="form-control" value="<?= $email ?>" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Services</label>
                        <select name="services" id="">
                            <option value="Hair Cut">Hair Cut</option>
                            <option value="Hair Wash">Hair Wash</option>
                            <option value="Hair Color">Hair Color</option>
                            <option value="Hair Shave">Hair Shave</option>
                            <option value="Hair Straight">Hair Straight</option>
                            <option value="Facial">Facial</option>
                            <option value="Shampoo">Shampoo</option>
                            <option value="Beard Trim">Beard Trim</option>
                            <option value="Beard Shave">Beard Shave</option>
                            <option value="Wedding Cut">Wedding Cut</option>
                            <option value="Clean Up">Clean Up</option>
                            <option value="Massage">Massage</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Time</label>
                        <?php echo '<select name="time">' . $dropdown . '</select>'; ?>
                        <?=$Error?>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                    <button class="btn btn-primary" name="back"><a style="text-decoration: none; color:#fefefe ;">Back</a></button>
                    </div>
                    

                </form>

                <div class="form-group ">
                        <?=$Booked?>
                    </div>
            </div>

        </div>
        
    </div>

    <div id="myModal" class="modal" <?= $pop_up ?> >

        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>BOOKING DETAILS:</h1>
            <ul>
                <li><p><strong>Date:    </strong>  <?php echo $date     ?>    </p></li>
                <li><p><strong>Name:    </strong>  <?php echo $name     ?>    </p></li>
                <li><p><strong>Email:   </strong>  <?php echo $email;   ?>    </p></li>
                <li><p><strong>Time:    </strong>  <?php echo $time     ?> pm </p></li>
                <li><p><strong>Service  </strong>  <?php echo $services;?>    </p></li>
                <li><p><strong>price:   </strong> $<?php echo $price    ?>    </p></li>
            </ul>
            <button id="btn">OK</button>
        </div>

    </div>

    
    <div style="height: 200px;">
    </div>
        <!-- Footer Start -->
        <?php
    include_once('../footer.php');
    ?>
    <!-- Footer End -->
   
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");

            // Open the modal automatically on page load
            modal.style.display = "block";

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }
            btn.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
</body>

</html>