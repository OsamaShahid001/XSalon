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
    $name = $row[1];
    $email = $row[2];
    $password = $row[3];
    $img = $row[4];
}

// $query = "SELECT * FROM `users` where `name` = '$user' OR `email` = '$user'";
// $result = mysqli_query($con,$query);
// while ($row = mysqli_fetch_array($result)){
//     $email = $row[2];
// }

?>
<!-- Calender Function -->
<?php
function build_calendar($month, $year)
{
    require "../function/connection.php";

    $query = "SELECT * FROM `bookings` WHERE MONTH(`date`) = '$month' AND YEAR(`date`) = '$year'";
    $result = mysqli_query($con, $query);

    $bookings = array();

    // if (mysqli_num_rows($result)> 0) {
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         $bookings[] = $row['date'];
    //     }
    //     mysqli_free_result($result);

    // }

    //     $dateToCheck = "2023-12-25"; // Replace with the date you want to check
    // $query = "SELECT COUNT(*) as count FROM `bookings` WHERE `date` = '2024-01-01'";
    // $stmt = $con->prepare($query);

    // if ($stmt) {
    //     $stmt->bind_param('s', $dateToCheck);
    //     $stmt->execute();
    //     $result = $stmt->get_result();

    //     if ($result) {
    //         $row = $result->fetch_assoc();
    //         $count = $row['count'];

    //         // Check if the count for the date is 7
    //         if ($count === 7) {
    //             echo "The date $dateToCheck occurs 7 times in the database.";
    //         } else {
    //             echo "The date $dateToCheck does not occur 7 times in the database.";
    //         }
    //     }

    //     $stmt->close();
    // }


    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    // How many days does this month contain?
    $numberDays = date('t', $firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];

    // Create the table tag opener and day headers

    $datetoday = date('Y-m-d');


    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a style='font-size:12px;' class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a> ";

    $calendar .= " <a style='font-size:12px;' class='btn btn-xs btn-primary' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";

    $calendar .= "<a style='font-size:12px;' class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";



    $calendar .= "<tr>";

    // Create the calendar headers

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th  class='header'>$day</th>";
    }

    // Create the rest of the calendar

    // Initiate the day counter, starting with the 1st.

    $currentDay = 1;

    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td  class='empty'></td>";
        }
    }


    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        // Seventh column (Saturday) reached. Start a new row.

        if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $dayname = strtolower(date('l', strtotime($date)));
        $eventNum = 0;
        $today = $date == date('Y-m-d') ? "today" : "";
        if ($date < date('Y-m-d')) {
            $calendar .= "<td><h4>$currentDay</h4> <button style='font-size:12px;'' class='btn btn-danger btn-xs'>N/A</button>";
        } elseif (in_array($date, $bookings)) {
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <button style='font-size:12px;' class='btn btn-danger btn-xs'>Already Booked</button>";
        } else {

            $query = "SELECT * FROM `bookings` WHERE date = '$date'";
            $result = mysqli_query($con, $query);
            $totalbookings = 0;
            if ($row = mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_array($result)) {
                    $totalbookings++;
                }
            }
            $total = 7;
            $totalbookings;
            $Slotsleft = 7 - $totalbookings;
            // echo $Slotsleft;
            // echo $row;

            if ($totalbookings == 7) {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='#' style='font-size:12px;' class='btn btn-danger btn-xs'>All Booked</a>";
            } else {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a  href='book.php?date=" . $date . "' style='font-size:12px;' class='btn btn-success btn-xs'>Book</a><p style='font-size: 10px; margin-top:10px;'!important>$Slotsleft Slots left</p>";
            }
        }


        $calendar .= "</td>";
        // Increment counters

        $currentDay++;
        $dayOfWeek++;
    }



    // Complete the row of the last week in month, if necessary

    if ($dayOfWeek != 7) {

        $remainingDays = 7 - $dayOfWeek;
        for ($l = 0; $l < $remainingDays; $l++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $calendar .= "</tr>";

    $calendar .= "</table>";

    echo $calendar;
}


?>
<!DOCTYPE html>
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



        /*
		Label the data
		*/
        td:nth-of-type(1):before {
            content: "Sunday";
        }

        td:nth-of-type(2):before {
            content: "Monday";
        }

        td:nth-of-type(3):before {
            content: "Tuesday";
        }

        td:nth-of-type(4):before {
            content: "Wednesday";
        }

        td:nth-of-type(5):before {
            content: "Thursday";
        }

        td:nth-of-type(6):before {
            content: "Friday";
        }

        td:nth-of-type(7):before {
            content: "Saturday";
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
            table-layout: fixed;
        }

        td {

            margin: auto;
            width: 50%;
            text-align: center;

        }
    }

    /* .row {
        margin-top: 20px;
    } */

    .today {
        background: yellow;
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
                    <a href="home.php" class="nav-item nav-link">Home</a>
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
                            <img src="../<?= $img ?>" alt="mdo" width="32" height="32" class="rounded-circle">
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
                    <a href="#">booking</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Page Calendar Start -->
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $dateComponents = getdate();
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                } else {
                    $month = $dateComponents['mon'];
                    $year = $dateComponents['year'];
                }
                echo build_calendar($month, $year);
                ?>
            </div>
        </div>
    </section>
    <!-- Page Calendar End -->

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
                echo '<script>alert("Sent");window.location="booking.php"</script>';
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/isotope/isotope.pkgd.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>

    <!-- booking Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/booking.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>