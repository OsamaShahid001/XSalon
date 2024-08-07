<?php
require "../function/connection.php";
session_start();
if ($_SESSION["user"] == null) {
    header('location: ../index.php');
}
// ?>
<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: ../index.php");
}

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xsalon-Home</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
            <a href="#" class="navbar-brand">Barber <span>X</span></a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto">
                    <a href="home.php" class="nav-item nav-link active">Home</a>
                    <a href="booking.php" class="nav-item nav-link">Booking</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="service.php" class="nav-item nav-link">Service</a>
                    <a href="portfolio.php" class="nav-item nav-link">Gallery</a>

                    <a href="" class="nav-item nav-link">Contact</a>
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



    <!-- Hero Start -->
    <div class="hero">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="hero-text">
                        <h1><span style="font-size:60px">W</span>elcome To <span style="font-size:100px; ">XS</span>ALON</h1>
                        <p>
                            Where Style Meets Serenity! Step into a world of exquisite pampering and personalized beauty. Discover an oasis of elegance where our expert stylists craft signature looks tailored to elevate your unique charm. Experience the fusion of exceptional service, trendsetting techniques, and a tranquil ambiance, all devoted to unveiling your utmost beauty. Unwind, indulge, and transform at XSalon – Where Every Style Tells a Story.
                        </p>
                        <a class="btn" href="booking.php">BOOKING</a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 d-none d-md-block">
                    <div class="hero-image">
                        <img src="../img/hero.png" alt="Hero Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- About Start -->
    <div class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="about-img">
                        <img src="../img/about.jpg" alt="Image">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="section-header text-left">
                        <p>Learn About Us</p>
                        <h2>25 Years Experience</h2>
                    </div>
                    <div class="about-text">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem. Curabitur non nisl nec nisi scelerisque maximus. Aenean consectetur convallis porttitor. Aliquam interdum at lacus non blandit.
                        </p>
                        <a class="btn" href="">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

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
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non
                        </p>
                        <a class="btn" href="">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="../img/service-2.jpg" alt="Image">
                        </div>
                        <h3>Beard Style</h3>
                        <p>
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non
                        </p>
                        <a class="btn" href="">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="../img/service-3.jpg" alt="Image">
                        </div>
                        <h3>Color & Wash</h3>
                        <p>
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non
                        </p>
                        <a class="btn" href="">Learn More</a>
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

    <!-- Testimonial Start -->
    <div class="testimonial">
        <div class="container">
            <div class="owl-carousel testimonials-carousel">
                <?php

                   $query = "SELECT * FROM `reviews`";
                   $result = mysqli_query($con,$query);
                   while ($row=mysqli_fetch_assoc($result)) {
                    $ids = $row['user_id'];
                    echo '
                    <div class="testimonial-item">
                    <img src="../'.$row['image'].'" height=60 alt="Image">';
                    echo  'rating:'.$row['ratings'];
                    echo '<p>"'.$row['reviews'].'"</p>
                    
                    <h2>'.$row['name'].'</h2>
                    </div>';

                   }
                ?>
            </div>
        </div>
    </div>

    <!-- Testimonial End -->
    <!-- Footer Start -->
    <?php
    include_once('../footer.php');
    ?>
    <!-- Footer End -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/isotope/isotope.pkgd.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>