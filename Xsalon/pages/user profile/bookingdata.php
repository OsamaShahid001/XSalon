<?php

use Random\Engine\PcgOneseq128XslRr64;

require "../../function/connection.php";
session_start();
if ($_SESSION["user"] == null) {
    header('location: ../../login/login.php');
}
?>
<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: ../../index.php");
}
$user = $_SESSION['user'];
$id = $_SESSION['id'];
$query = "SELECT * FROM `users` where `id` = '$id'";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $name = $row[1];
    $email = $row[2];
    $password = $row[3];
    $img = $row[4];
}

?>
<?php
// -------------------update---------------------------

$errors    = null;

if (isset($_POST["profile-update"])) {

    $uname    = trim($_POST["uname"]);
    $upass    = $_POST["upass"];
    echo $upass;
    if (!empty($uname and $upass)) {
        $upass    = md5($upass);

        if (isset($_FILES['image'])) {
            $filename  = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp  = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            move_uploaded_file($file_tmp, "../../img/" . $filename);
        }
        if ($filename == null) {
            $filename = $img;
        }
        $query = "UPDATE `users` SET `name`='$uname',`password`='$upass', `image`='img/$filename' WHERE `id` = '$id' ";
        $result = mysqli_query($con, $query);
        if ($result) {
            echo '<script>alert("Profile Updated");window.location="profile.php" </script>';
        } else {
            echo "<script>alert('Data Not updated')</script>";
        }
    } else {
        $errors = "<div class='alert alert-danger'>Please fill All the Fields</div>";
    }
}
?>

<!-- ----------------------------delete-------------------------------- -->
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "delete from `bookings` where ID = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo '<script>alert("Booking Canceled");window.location="bookingdata.php" </script>';
    } else {
        echo "<script>alert('booking Not Canceled')</script>";
    }
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
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="../../admin/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="../../css/style.css" rel="stylesheet">
</head>
<style>
    body {
        margin: 0;
        font-family: "Lato", sans-serif;
    }

    .header {
        background: #363b41;
        color: #fff;
        height: 100px;
    }

    .head {
        z-index: -1;
    }

    .top-bar {
        z-index: 2;
    }

    hr {
        background-color: #888;
    }

    .sidebar {
        margin: 0;
        padding: 0;
        width: 250px;
        background-color: #1d2434;
        /* background-color: #fff; */
        position: fixed;
        height: 110%;
        overflow: hidden;
        margin-top: -60px;
        z-index: 0;
    }
    @media (max-width: 700px) {
        .sidebar {
        margin-top: 0px;
    }}
    .sidebar a {
        display: block;
        color: #fff;
        padding: 16px;
        text-decoration: none;
        border: 1px solid #1d2434;
    }

    .sidebar a.active {
        background-color: #D5B981;
        color: white;
    }

    .sidebar a:hover:not(.active) {
        background-color: #555;
        color: white;
    }

    div.content {
        margin-left: 200px;
        padding: 1px 16px;
        height: 1000px;
    }

    @media screen and (max-width: 700px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .sidebar a {
            float: left;
        }

        div.content {
            margin-left: 0;
        }
    }

    @media screen and (max-width: 400px) {
        .sidebar a {
            text-align: center;
            float: none;
        }
    }

    /* Full-width input fields */
    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Set a style for all buttons */
    .tabcontent button {
        background-color: #1d2434;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border-width: 3px;
        color: #D5B981;
        border-color: #D5B981;
        cursor: pointer;
        width: 100%;
        transition: 0.3s ease;
    }

    .tabcontent button:hover {
        opacity: 0.9;
        background: #D5B981;
        color: #1d2434;
    }

    /* Extra styles for the cancel button */
    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    /* Center the image and position the close button */
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
        position: relative;
    }

    img.avatar {
        width: 100px;
        border-radius: 50%;
    }

    .container {
        padding: 16px;
    }

    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
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
        padding-top: 60px;
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto;
        /* 5% from the top, 15% from the bottom and centered */
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button (x) */
    .close {
        position: absolute;
        right: 25px;
        top: 0;
        color: #000;
        font-size: 35px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: red;
        cursor: pointer;
    }

    /* Add Zoom Animation */
    .animate {
        -webkit-animation: animatezoom 0.6s;
        animation: animatezoom 0.6s
    }

    @-webkit-keyframes animatezoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes animatezoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }

        .cancelbtn {
            width: 100%;
        }
    }

    * {
        scroll-behavior: smooth;
    }

    @media only screen and (max-width: 760px),
    (min-device-width: 802px) and (max-device-width: 1020px) {

        /* Force table to not be like tables anymore */
        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;

        }



        .empty {
            display: none;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        th {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            border: 1px solid #ccc;
        }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

    }

    /* Smartphones (portrait and landscape) ----------- */

    @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
        body {
            padding: 0;
            margin: 0;
        }
    }


    @media (min-width:641px) {
        table {
        }

        td {

            margin: auto;
            text-align: center;

        }
    }

</style>
</head>

<body>

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


            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto">
                    <a href="../home.php" class="nav-item nav-link">Home</a>
                    <a href="../booking.php" class="nav-item nav-link">Booking</a>

                    <a href="../about.php" class="nav-item nav-link">About</a>
                    <a href="../service.php" class="nav-item nav-link">Service</a>
                    <a href="../portfolio.php" class="nav-item nav-link">Gallery</a>
                    <a href="../contact.php" class="nav-item nav-link">Contact</a>
                    <?php
                    if (isset($_SESSION['user'])) {
                        $dates = date('Y-m-d');
                        $query = "SELECT * FROM `bookings` WHERE `user_id`='$id' AND (`date`<'$dates' AND feedback = '')";
                        $result = mysqli_query($con, $query);
                        $count = mysqli_num_rows($result);
                        if ($count > 0) {
                            echo '<a href="feed.php" class="nav-item nav-link">Feedback</a>';
                        }
                    }
                    ?>

                    <div class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../<?= $img ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>

                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item"><?php echo $_SESSION['user']; ?></a></li>
                            <li><a class="dropdown-item active" href="profile.php">Settings</a></li>
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
    <div class="sidebar tab">
        <form method="get">
            <a href="../home.php" style="text-align: center; font-size:20px; margin-top:100px;"><strong>XS</strong>alon</a>
            <hr>
            <a class="tablinks" href="profile.php">Profile</a>
            <a class="tablinks active" href="bookingdata.php">Bookings</a>
        </form>
    </div>
    <div class="head" style="background: #D5B981; width:100%; height: 200px; text-align:center;padding-top:80px; ">
        <h2>PROFILE</h2>
        <a href="../home.php">Home</a> /
        <a href="">Bookings</a>
    </div>
    <div class="content" style="height: auto;">

        <div id="profile" class="tabcontent" style="margin: 50px; ">

            <!-- <form method="get">
            <input style="width: 400px; height:40px;" type="search" placeholder="Search" name="src">
            <button style="width: 200px; background-color:violet" name="btn">submit</button>
         </form> -->
            <!-- <form method="GET">
                <input type="text" style="width-max: 400px;" name="src" placeholder="Search...">
                <input type="submit" style="width: 200px;  height:50px;" name="btn" value="Search">
            </form> -->

            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Today's Booking's
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                                        <thead>
                                            <th>booking ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Services</th>
                                            <th>Time</th>
                                            <th>Date</th>
                                            <th>Bookings</th>
                                            <th>Price</th>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $price = 0;

                                            if (isset($_GET['btn']) && isset($_GET['src'])) {
                                                $src = $_GET['src'];
                                                $query = "SELECT * FROM `bookings` WHERE `user_id` = '$id' AND (`id` LIKE '%$src%' OR `name` LIKE '%$src%' OR `services` LIKE '%$src%' OR `time` LIKE '%$src%' OR `date` LIKE '%$src%')";

                                                $data =  mysqli_query($con, $query);

                                                while ($result = mysqli_fetch_array($data)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $result[0] . "</td>";
                                                    echo "<td>" . $result[3] . "</td>";
                                                    echo "<td>" . $result[4] . "</td>";
                                                    echo "<td>" . $result[5] . "</td>";
                                                    echo "<td>" . $result[2] . "</td>";
                                                    echo "<td>" . $result[1] . "</td>";
                                                    if ($result[1] > date('Y-m-d')) {
                                                        echo "<td>" . '<a style="color:red" href="bookingdata.php?id=' . $result['id'] . '">Cancel Booking</a>' . "</td>";
                                                    } else {
                                                        echo "<td style='color:green'>" . "Finished" . "</td>";
                                                    }
                                                    echo "<td>" . $result[6] . "</td>";

                                                    echo "</tr>";
                                                }
                                            } else {

                                                $query = "SELECT * FROM `bookings` where `user_id` = '$id'";
                                                $data =  mysqli_query($con, $query);
                                                while ($result = mysqli_fetch_array($data)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $result[0] . "</td>";
                                                    echo "<td>" . $result[3] . "</td>";
                                                    echo "<td>" . $result[4] . "</td>";
                                                    echo "<td>" . $result[5] . "</td>";
                                                    echo "<td>" . $result[2] . "</td>";
                                                    echo "<td>" . $result[1] . "</td>";

                                                    if ($result[1] > date('Y-m-d')) {
                                                        echo "<td>" . '<a style="color:red" href="bookingdata.php?id=' . $result['id'] . '">Cancel Booking</a>' . "</td>";
                                                    } else {
                                                        echo "<td style='color:green'>" . "Finished" . "</td>";
                                                    }

                                                    echo "<td>" . $result[6] . "</td>";


                                                    echo "</tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
    // include_once('../../footer.php');
    ?>
    </div>
    <?php
    include_once('../../footer.php');
    ?>



    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
    <script src="../../admin/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../../admin/assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTables').dataTable();
        });
    </script>

</body>

</html>

</head>

<body>