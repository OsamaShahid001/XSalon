<?php
require "../function/connection.php";
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: ../index.php");
}

$id = $_SESSION['id'] ?? '';
$query = "SELECT * FROM `users` where `id` = '$id'";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $name = $row[1];
    $email = $row[2];
    $password = $row[3];
    $img = $row[4];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Barber X - Barber Shop Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

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

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Top Bar Start -->
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
                    <a href="home.php" class="nav-item nav-link">Home</a>
                    <?php if (isset($_SESSION['user'])) {
                         echo '<a href="booking.php" class="nav-item nav-link">Booking</a>';
                        }
                        ?>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="service.php" class="nav-item nav-link active">Service</a>
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
                    <?php if (isset($_SESSION['user'])) {
                        echo '<div class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../'. $img .'" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item">'. $_SESSION['user'].'</a></li>
                            <li><a class="dropdown-item" href="user profile/profile.php">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form method="post">
                                <li><button type="submit" class="dropdown-item" name="logout">Logout</button></li>
                            </form>
                        </ul>
                    </div>';}else{
                     echo '<a href="../login/login.php" class="nav-item nav-link">Login</a>';
                    }
                    ?>
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
                    <h2>Service</h2>
                </div>
                <div class="col-12">
                    <a href="home.php">Home</a>
                    <a href="">Service</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Service Start -->
    <div class="service">
        <div class="container">
            <div class="section-header text-center">
                <p>Our Salon Services</p>
                <h2>Best Salon and Barber Services for You</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="../img/service-1.jpg" alt="Image">
                        </div>
                        <h3>Hair Cut</h3>
                        <p>
                        Transform your look with precision-crafted beard styles that reflect sophistication and individuality, curated by our seasoned professionals.
                        </p>
                        <!-- <a class="btn" href="">Learn More</a> -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="../img/service-2.jpg" alt="Image">
                        </div>
                        <h3>Beard Style</h3>
                        <p>
                        Elevate your style with expertly crafted beard designs, embodying sophistication and individuality by our seasoned professionals.
                        </p>
                        <!-- <a class="btn" href="">Learn More</a> -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="../img/service-3.jpg" alt="Image">
                        </div>
                        <h3>Color & Wash</h3>
                        <p>
                        Transform with precision color and rejuvenating wash for a vibrant, stunning look in one seamless experience.
                        </p>
                        <!-- <a class="btn" href="">Learn More</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->



        <!-- Pricing Start -->
        <div class="price">
            <div class="container">
                <div class="section-header text-center">
                    <p>Our Best Pricing</p>
                    <h2>We Provide Best Price in the City</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-1.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Hair Cut</h2>
                                <h3>$9.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-2.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Hair Wash</h2>
                                <h3>$10.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-3.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Hair Color</h2>
                                <h3>$11.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-4.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Hair Shave</h2>
                                <h3>$12.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-5.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Hair Straight</h2>
                                <h3>$13.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-6.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Facial</h2>
                                <h3>$14.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-7.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Shampoo</h2>
                                <h3>$15.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-8.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Beard Trim</h2>
                                <h3>$16.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-9.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Beard Shave</h2>
                                <h3>$17.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-10.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Wedding Cut</h2>
                                <h3>$18.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-11.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Clean Up</h2>
                                <h3>$19.99</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="price-item">
                            <div class="price-img">
                                <img src="../img/price-12.jpg" alt="Image">
                            </div>
                            <div class="price-text">
                                <h2>Massage</h2>
                                <h3>$20.99</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pricing End -->
    <!-- Footer Start -->
    <?php
    include_once('../footer.php');
    ?>
    <!-- Footer End -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/isotope/isotope.pkgd.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../mail/jqBootstrapValidation.min.js"></script>
    <script src="../mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>

</body>

</html>