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
            <a href="index.html" class="navbar-brand">Salon <span>X</span></a>
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
                    <a href="service.php" class="nav-item nav-link">Service</a>
                    <a href="portfolio.php" class="nav-item nav-link">Gallery</a>
                    <a href="contact.php" class="nav-item nav-link active">Contact</a>
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
                    <h2>Contact</h2>
                </div>
                <div class="col-12">
                    <a href="home.php">Home</a>
                    <a href="">Contact</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <?php
    if (isset($_POST['btn'])) {


        $m_name = trim($_POST['name']);
        $m_email = trim($_POST['email']);
        $m_subject = trim($_POST['subject']);
        $m_msg = $_POST['msg'];
        if (!empty($m_email and $m_msg)) {
            $query = "INSERT INTO `contact_form`(`id`, `email`, `subject`, `message`, `user_id`) VALUES ('$m_name','$m_email','$m_subject]','$m_msg','$id')";
            $result = mysqli_query($con, $query);
            if ($result) {
                echo '<script>alert("Contact Form Submited");window.location="booking.php"</script>';
            } else {
                echo "<script>alert('Not Submitted')</script>";
            }
        }
    }
    //  echo $m_name;
    //  echo $m_email;
    //  echo $m_subject;
    //  echo$m_msg;

    ?>
        <!-- Contact Start -->
        <div class="section-header text-center" style="margin-top: 90px;">
        <p>Get In Touch</p>
        <h2>If You Have Any Query, Please Contact Us</h2>
    </div>
    <div class="contact" style="margin-bottom: 90px;">
        <div class="container-fluid">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                        <div class="contact-form">
                            <div id="success"></div>
                            <form name="sentMessage" method="post">
                                <div class="control-group">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required />
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="control-group">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" required="required" />
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="control-group">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject" required="required" />
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="control-group">
                                    <textarea class="form-control" name="msg" id="message" placeholder="Message" required="required"></textarea>
                                    <p class="help-block text-danger" id="charCount"></p>
                                </div>
                                <div>
                                    <button class="btn" name="btn" type="submit" id="sendMessageButton">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Footer Start -->
    <?php
    include_once('../footer.php');
    ?>
    <!-- Footer End -->

    <script>
        const textarea = document.getElementById('message');
        const charCountDisplay = document.getElementById('charCount');

        textarea.addEventListener('input', function() {
            const text = this.value.replace(/\n/g, '');
            const textLength = text.length;

            // Change the limit here (250 characters in this case)
            const maxChars = 249;

            if (textLength >= maxChars) {
                this.value = text.slice(0, maxChars);
            }

            charCountDisplay.textContent = `Character count: ${textLength} / ${'250'}`;
        });
    </script>

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