<?php
require "../function/connection.php";
session_start();
if ($_SESSION["admin"] == null) {
    header('location: index.php');
} elseif ($_SESSION["admin"] == 'Staff') {
    $staffs = "";
} elseif ($_SESSION["admin"] == 'Receptionist') {
    $res = "";
} elseif ($_SESSION["admin"] == 'Admin') {
    $admin = "";
}
$name  =    $_SESSION["admin"];
$date  =    $_SESSION["date"];
$id    =    $_SESSION['id'];
$cdate = date('d-M-Y');
$query = "SELECT * FROM `admin` WHERE `id`='$id'";
$resulty = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($resulty)) {
    $fname   =   $row['username'];
}
?>
<?php
if (isset($_POST['logout'])) {
    $query = "UPDATE `admin` SET `date`='$cdate' WHERE `id`='$id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        session_destroy();
        header("location: index.php");
    }
}




?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $name ?>-UserControl</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- MORISS -->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><?= $name ?></a>
            </div>
            <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;">
                <form method="post">Last access : <?= $date ?>&nbsp;&nbsp;<button name="logout" type="submit" class="btn btn-danger square-btn-adjust">Logout</button> </form>
            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="assets/imgs/find_user.png" class="user-image img-responsive" />
                    </li>


                    <li>
                        <a class="active-menu" href="adminpanel.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                    <?php if($_SESSION["admin"] == 'Staff' or $_SESSION["admin"] == 'Receptionist'){
                              echo '<li>    
                                       <a href="staff-control/staff-account.php"><i class="fa fa-users fa-3x"></i> Staff Accounts</a>
                                   </li>';  
                         }else if($_SESSION["admin"] == 'Admin'){
                              echo '<li>
                                        <a href="users-control/users-account.php"><i class="fa fa-user fa-3x"></i> User Accounts</a>
                                    </li>';
                              echo '<li>    
                                        <a href="staff-control/staff-account.php"><i class="fa fa-users fa-3x"></i> Staff Accounts</a>
                                    </li>';  
                              echo '<li>
                                        <a href="inventory/inventory.php"><i class="fa fa-qrcode fa-3x"></i> Inventory</a>
                                   </li>';   
                        }

                        if($_SESSION["admin"] == 'Receptionist'){
                            echo '<li>
                                   <a href="inventory/inventory.php"><i class="fa fa-qrcode fa-3x"></i> Inventory</a>
                               </li>';}
                    ?>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><?= $name ?> Dashboard</h2>
                        <h5>Welcome <?= $fname ?> , Love to see you back. </h5>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
               
                <div class="row">
                     <?php if($_SESSION["admin"] == 'Staff'){
                                    $end = date('Y-m-31');
                                    $firstDayOfMonth = date('Y-m-01');
                                    $query = "SELECT * FROM `bookings` WHERE `date` >= '$firstDayOfMonth' and `date` <= '$end' ";
                                    $result = mysqli_query($con, $query);
                                    $counts = mysqli_num_rows($result);
                                }else if($_SESSION["admin"] == 'Admin' or $_SESSION["admin"] == 'Receptionist'){
                                    
                                    $query  = "SELECT * FROM `admin`";
                                    $result = mysqli_query($con, $query);
                                    $count  = mysqli_num_rows($result);
                                    $count  = $count - 1;
                                    echo '<div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="panel panel-back noti-box">
                                                    <span class="icon-box bg-color-red set-icon">
                                                        <i class="fa fa-bookmark"></i>
                                                    </span>
                                                    <div class="text-box">
                                                        <p class="main-text">'.$count.' Staffs</p>
                                                        <p class="text-muted">Total Staff</p>
                                                    </div>
                                                </div>
                                         </div>';
                                     $query = "SELECT * FROM `users`";
                                     $result = mysqli_query($con, $query);
                                     $count = mysqli_num_rows($result);
                                     echo '<div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="panel panel-back noti-box">
                                                    <span class="icon-box bg-color-green set-icon">
                                                        <i class="fa fa-user"></i>
                                                   </span>
                                                    <div class="text-box">
                                                        <p class="main-text">'.$count.' Users</p>
                                                        <p class="text-muted">Total users</p>
                                                    </div>
                                                </div>
                                          </div>';
                                     $query = "SELECT * FROM `inventory`";
                                     $result = mysqli_query($con, $query);
                                     $count = mysqli_num_rows($result);
                                     echo  '<div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="panel panel-back noti-box">
                                                    <span class="icon-box bg-color-blue set-icon">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span>
                                                    <div class="text-box">
                                                        <p class="main-text">'. $count.' Products</p>
                                                        <p class="text-muted">Total Products</p>
                                                    </div>
                                                </div>
                                            </div>';
                                     $end = date('Y-m-31');
                                     $firstDayOfMonth = date('Y-m-01');
                                     $query = "SELECT * FROM `bookings` WHERE `date` >= '$firstDayOfMonth' and `date` <= '$end' ";
                                     $result = mysqli_query($con, $query);
                                     $counts = mysqli_num_rows($result);
                                     echo '<div class="col-md-3 col-sm-6 col-xs-6">
                                               <div class="panel panel-back noti-box">
                                                    <span class="icon-box bg-color-brown set-icon">
                                                        <i class="fa fa-book"></i>
                                                    </span>
                                                    <div class="text-box">
                                                        <p class="main-text">'.$counts.' Bookings</p>
                                                        <p class="text-muted">Monthly Bookings</p>
                                                    </div>
                                                </div>
                                            </div>
                                         ';
                                }

                                ?>  
                 </div>


                <!-- /. ROW  -->
                <hr />
                <?php
                $d = date('Y-m-d');
                $query = "SELECT * FROM `bookings` WHERE `date` = '$d'";
                $result = mysqli_query($con, $query);
                $count = mysqli_num_rows($result);
                $totalPrice = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $uname   =   $row['name'];
                    $utime   =   $row['time'];
                    $uservice   =   $row['services'];
                }
                $day = date('Y-m-01');
                $days = date('Y-m-31');
                $query = "SELECT * FROM `bookings` WHERE `date` >= '$day' and `date` <= '$days'";
                $result = mysqli_query($con, $query);
                $totalPrice = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $price = floatval($row['price']);
                    $totalPrice += $price;
                }

                ?>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-blue">
                                <i class="fa fa-warning"></i>
                            </span>
                            <div class="text-box">
                                <p class="main-text"><?= $count ?> Booking Today</p>
                                <p class="text-muted">Todays Booking</p>

                                <hr>
                                <p class="text-muted">

                                    <span class="text-muted "><i class="fa fa-edit"></i>
                                        Showing You Only Todays Bookings If Exists, Below You Can See Who Books Todays Slots And Services.

                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel back-dash">
                            <i class="fa fa-dashboard fa-3x"></i><strong> &nbsp; SPEED UP!</strong>
                            <p class="text-muted">Don't Waste Clients Time, Do Work Fast, Provide Best Expertise. </p>
                        </div>

                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                        <div class="panel ">
                            <div class="main-temp-back">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-6"> <i class="fa fa-cloud fa-3x"></i> Karachi </div>
                                        <div class="col-xs-6">
                                            <div class="text-temp"> 18° </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-green set-icon">
                                <i class="fa fa-desktop"></i>
                            </span>
                            <div class="text-box">
                                <p class="main-text">Display</p>
                                <p class="text-muted">Looking Good</p>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /. ROW  -->

                <div class="row">


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
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Service</th>
                                                        <th>Time</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT * FROM `bookings` WHERE `date` = '$d'";
                                                    $data =  mysqli_query($con, $query);
                                                    while ($result = mysqli_fetch_assoc($data)) {
                                                        echo "<tr>";
                                                        echo "<td>" . $result['id'] . "</td>";
                                                        echo "<td>" . $result['name'] . "</td>";
                                                        echo "<td>" . $result['email'] . "</td>";
                                                        echo "<td>" . $result['services'] . "</td>";
                                                        echo "<td>" . $result['time'] . "</td>";
                                                        echo "<td>" . $result['date'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <!--End Advanced Tables -->
                            </div>
                        </div>
                    </div>
                    <?php
                    $t = date('g:i a')
                    ?>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-green">
                            <div class="panel-body">
                                <h3> From Booking</h3>
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                                <?php if($_SESSION["admin"] == 'Staff'){
                                    echo '<h3>'.$counts.'</h3>';
                                }else if($_SESSION["admin"] == 'Admin'){
                                    echo '<h3>Revenue: $'. $totalPrice.'</h3>';
                                }else if($_SESSION["admin"] == 'Receptionist'){
                                    echo '<h3>'.$counts.'</h3>';
                                }
                                ?>  
              
                            </div>
                            <div class="panel-footer back-footer-green">
                                Monthly
                            </div>
                        </div>
                        <div class="panel panel-primary text-center no-boder bg-color-red">
                            <div class="panel-body">
                                <i class="fa fa-clock fa-5x"></i>
                                <h3><?= $t ?></h3>
                            </div>
                            <div class="panel-footer back-footer-red">
                                Leave at 8:00 pm

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /. ROW  -->



                <!-- /. ROW  -->
                <?php if($_SESSION["admin"] == 'Staff' or $_SESSION["admin"] == 'Receptionist'){
                                    
                                }else if($_SESSION["admin"] == 'Admin'){
                                    echo   '<div class="row">
                                    <div class="col-md-9  col-sm-12 col-xs-12">
                
                                        <div class="chat-panel panel panel-default chat-boder chat-panel-head">
                                            <div class="panel-heading">
                                                <i class="fa fa-comments fa-fw"></i>
                                                Reviews Box
                
                
                                                <div class="panel-body">
                                                    <ul class="chat-box">';
                                                    

                                                    $query = "SELECT * FROM `reviews`";
                                                    $result = mysqli_query($con,$query);
                                                    while ($row=mysqli_fetch_assoc($result)) {
                                                     $ids = $row['user_id'];

                                                     echo '
                                                     <li class="left clearfix">
                                                     <span class="chat-img pull-left">
                                                                <img src="../'.$row['image'].'" alt="User" height=50 width= 50 class="img-circle" />
                                                            </span>
                                                            <div class="chat-body">
                                                            <strong>'.$row['name'].'</strong>
                                                            <small class="pull-right text-muted">
                                                            ';
                                                           echo  $row['ratings'];
                                                            for ($i = 0; $i < $row['ratings']; $i++) {
                                                                echo '<i class="fa fa-star-o"></i>';
                                                            }
                                                        echo '</small>
                                                     <p>'.$row['reviews'].'</p>
                                                     </div>
                                                     </li>';
                                                    }
                                                 
                                                       echo '
                                                    </ul>
                                                </div>
                
                                            </div>
                
                                        </div>
                
                                    </div>
                                    <!-- /. ROW  -->
                                    <div class="row">
                
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="panel panel-primary text-center no-boder bg-color-green">
                                                <div class="panel-body">
                                                    <i class="fa fa-comments-o fa-5x"></i>
                                                    <h4>200 New Comments </h4>
                                                    <h4>See All Comments </h4>
                                                </div>
                                                <div class="panel-footer back-footer-green">
                                                    <i class="fa fa-rocket fa-5x"></i>
                                                    Lorem ipsum dolor sit amet sit sit, consectetur adipiscing elitsit sit gthn ipsum dolor sit amet ipsum dolor sit amet
                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /. PAGE INNER  -->
                                </div>';
                                }
                                ?>  
                <!-- /. PAGE WRAPPER  -->
            </div>
            <!-- /. WRAPPER  -->
            <!-- JQUERY SCRIPTS -->
            <script src="assets/js/jquery-1.10.2.js"></script>
            <!-- BOOTSTRAP SCRIPTS -->
            <script src="assets/js/bootstrap.min.js"></script>
            <!-- METISMENU SCRIPTS -->
            <script src="assets/js/jquery.metisMenu.js"></script>
            <!-- DATA TABLE SCRIPTS -->
            <script src="assets/js/dataTables/jquery.dataTables.js"></script>
            <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
            <script>
                $(document).ready(function() {
                    $('#dataTables').dataTable();
                });
            </script>
            <!-- CUSTOM SCRIPTS -->
            <script src="assets/js/custom.js"></script>
            <script src="admin/assets/js/morris/morris.js"></script>
            <script src="admin/assets/js/morris/raphael-2.1.0.min.js"></script>

</body>

</html>