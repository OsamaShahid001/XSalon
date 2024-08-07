<?php
require "../../function/connection.php";
session_start();
if ($_SESSION["user"] == null) {
    header('location: ../../login/login.php');
}

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
    $img = $row[4];
}

if (isset($_GET['id'])) {
    $ID = $_GET['id'];
    $query = "SELECT * FROM `bookings` where `id` = '$ID'";
    $result = mysqli_query($con, $query);
    while ($data = mysqli_fetch_assoc($result)) {
        $service = $data['services'];
    }
} else {
    header('location:../home.php');
}

if (isset($_POST['rating'])) {
    $fname = $name;
    $femail = $email;
    $frating = $_POST['rating'];
    $feedback = mysqli_real_escape_string($con, $_POST['feedback']);
    $imgs = $img;
    $no = $id;
    $query = "SELECT `feedback` FROM `bookings` WHERE `id` = '$ID' and `feedback` = 'Feedback'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);
    if ($count < 1) {
        $query = "INSERT INTO `reviews`(`name`, `email`, `ratings`, `reviews`, `user_id`, `image`) VALUES ('$fname','$femail','$frating','$feedback','$no','$imgs')";
        $result = mysqli_query($con, $query);
        if ($result) {
            $msg = "<div class='alert alert-success'>Rating Successfully Submitted</div>";
            $query = "UPDATE `bookings` SET `feedback` = 'Feedback' WHERE `id` = '$ID'";
            $result = mysqli_query($con, $query);
        } else {
            $msg = null;
        }
    } else {
        $msg = "<div class='alert alert-danger'>Already Submitted</div>";
    }
}

if (isset($_POST['back'])) {
    header("Location: feed.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
            <a href="home.php" class="navbar-brand"><span>XS</span>alon</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto">
                    <a href="../home.php"     class="nav-item nav-link ">Home</a>
                    <a href="../booking.php"  class="nav-item nav-link">Booking</a>
                    <a href="../about.php"    class="nav-item nav-link">About</a>
                    <a href="../service.php"  class="nav-item nav-link">Service</a>
                    <a href="../portfolio.php"class="nav-item nav-link">Gallery</a>
                    <a href="../contact.php"  class="nav-item nav-link">Contact</a>
                    <?php
                    if(isset($_SESSION['user'])){
                        $dates = date('Y-m-d');
                        $query = "SELECT * FROM `bookings` WHERE `user_id`='$id' AND (`date`<'$dates' AND feedback = '')";
                        $result = mysqli_query($con, $query);
                        $count = mysqli_num_rows($result);
                        if($count > 0){
                           echo '<a href="feed.php" class="nav-item nav-link active">Feedback</a>';
                        }}
                    ?>
                    <div class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../<?= $img ?>" alt="mdo" width="32" height="32" class="rounded-circle">
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
                    <a href="../home.php">Home</a>
                    <a href="feed.php">Feedback</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Header End -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                <br><br>
                <h2 class="text-center">Rate This Service</h2>
                <?php if (isset($service)) {
                    echo $service;
                } ?>
                <hr>
                <?php if (isset($msg)) {
                    echo $msg;
                } ?>
                <form id="my-form" method="post">
                    <div class="form-group">
                        <label>Rating</label>
                        <div id="rating-input"></div>
                    </div>

                    <div class="form-group">
                        <label>Feedback</label>
                        <textarea type="text" id="message" class="form-control" name="feedback"></textarea>
                        <input type="hidden" name="rating" id="rating">
                        <p class="help-block text-success" id="charCount"></p>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button class="btn btn-primary">Submit</button>
                        <button class="btn btn-primary" name="back"><a style="text-decoration: none; color:#fefefe ;">Back</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="height: 200px;"></div>
    <script>
        $(function() {
            $("#rating-input").rateYo({
                rating: 0,
                fullStar: "true",
                onSet: function(rating, rateYoinstance) {
                    $("#rating").val(rating);
                }
            });
        });
    </script>
    <script>
        const textarea = document.getElementById('message');
        const charCountDisplay = document.getElementById('charCount');

        textarea.addEventListener('input', function() {
            const text = this.value.replace(/\n/g, '');
            const textLength = text.length;

            // Change the limit here (250 characters in this case)
            const maxChars = 99;

            if (textLength >= maxChars) {
                this.value = text.slice(0, maxChars);
            }

            charCountDisplay.textContent = `${textLength} / ${'100'}`;
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
    <script src="../../js/main.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

</body>

</html>