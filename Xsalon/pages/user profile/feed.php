<?php
require "../../function/connection.php";
session_start();
if ($_SESSION["user"] == null) {
    header('location: ../login/login.php');
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
    $email = $row[2];
    $img = $row[4];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="../../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../admin/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>

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
                    <a href="../home.php" class="nav-item nav-link">Home</a>
                    <a href="../booking.php" class="nav-item nav-link active">Booking</a>

                    <a href="../about.php" class="nav-item nav-link">About</a>
                    <a href="../service.php" class="nav-item nav-link">Service</a>
                    <a href="../portfolio.php" class="nav-item nav-link">Gallery</a>
                    <a href="../contact.php" class="nav-item nav-link">Contact</a>
                    <?php
                    if(isset($_SESSION['user'])){
                        $dates = date('Y-m-d');
                        $query = "SELECT * FROM `bookings` WHERE `user_id`='$id' AND (`date`<'$dates' AND feedback = '')";
                        $result = mysqli_query($con, $query);
                        $count = mysqli_num_rows($result);
                        if($count > 0){
                           echo '<a href="feed.php" class="nav-item nav-link">Feedback</a>';
                        }}
                    ?>
                    <div class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../<?= $img ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item"><?php echo $_SESSION['user']; ?></a></li>
                            <li><a class="dropdown-item" href="profile.php">Settings</a></li>
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
                    <h2>Feedback</h2>
                </div>
                <div class="col-12">
                    <a href="../home.php">Home</a>
                    <a href="#">Feedback</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- feedback start -->
    <?php
    $dates = date('Y-m-d');
    $query = "SELECT * FROM `bookings` WHERE `user_id`='$id' AND (`date`<'$dates' AND feedback = '') ORDER BY `date` DESC";
    $result = mysqli_query($con, $query);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive style=" flex:none;>
                            <table class="table table-striped table-bordered table-hover" style="flex:none;" id="dataTabless">
                                <thead>
                                    <tr>
                                        <th>date</th>
                                        <th>Service</th>
                                        <th>Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "<td>" . $row['services'] . "</td>";
                                        echo "<td>" . '<a href="feedback.php?id=' . $row['id'] . '">Feedback</a>' . "</td>";
                                        echo "</tr>";
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
    <!-- feedback End -->
    <!-- Footer Start -->
    <?php
    include_once('../../footer.php');
    ?>
    <!-- Footer End -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
</body>

</html>