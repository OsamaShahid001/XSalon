<?php
require "../../function/connection.php";
session_start();
if ($_SESSION["admin"] == null or $_SESSION["admin"] == "Receptionist" ) {
    header('location: ../index.php');
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
    $query = "UPDATE `admin` SET `date`='$cdate' WHERE  `id`='$id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        session_destroy();
        header("location: ../index.php");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin-user-control</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a class="navbar-brand" href="../adminpanel.php"><?=$name?></a> 
            </div>
  <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;">
                <form method="post">Last access : <?= $date ?>&nbsp;&nbsp;<button name="logout" type="submit" class="btn btn-danger square-btn-adjust">Logout</button> </form>
        </nav>   
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="../assets/imgs/find_user.png" class="user-image img-responsive" />
                    </li>


                    <li>
                        <a href="../adminpanel.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                    <li>
                        <a  href="../users-control/users-account.php"><i class="fa fa-user fa-3x"></i> User Accounts</a>
                    </li>
                    <li>
                        <a class="active-menu" href="staff-account.php"><i class="fa fa-users fa-3x"></i> Staff Accounts</a>
                    </li>
                    <li>
                        <a href="../inventory/inventory.php"><i class="fa fa-qrcode fa-3x"></i> Inventory</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Add-Staff</h2>   
                        <h5>Welcome <?= $fname ?> , Love to see you back. </h5>
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
                 <?php
                 
                 if(isset($_POST['add'])){
                    $name = $_POST['name'];                   
                    $email = $_POST['email'];
                    $pass = $_POST['pass'];                    
                    $cpass = $_POST['cpass'];                    
                    $role = $_POST['role'];
                    $cdate = date('d-M-Y');
                   
                if(!empty($name and $email and $pass and $role)){
                if($cpass == $pass){
                    $pass = md5($pass);
                    $query = "INSERT INTO `admin`(`username`, `email`, `password`, `Role`, `join_date`) VALUES ('$name','$email','$pass','$role','$cdate')";
                    $result = mysqli_query($con,$query);
                    if($result){
                        echo "<script type='text/javascript'>alert('Successfully added $role');window.
                        location='staff-account.php';</script>";
                    }
                }else{
                    $error = "<div class='alert alert-danger'>Password Does Not Match!</div>";
                }
                }else{
                    $Error = "<div class='alert alert-danger'>Please fill all the fields!</div>";
                }
                }
                 ?>

<form method="post">


    <h3>Please Enter Details:</h3>
    <?=$Error ?? null?>
    <form role="form">
        <div class="form-group input-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" placeholder="Username" name="name">
        </div>        
        <div class="form-group input-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="text" class="form-control" placeholder="Email" name="email">
        </div>

        <div class="form-group input-group">
            <span class="input-group-addon"><i class="fa-solid fa-lock"></i></span>
            <input type="text" class="form-control" placeholder="Password" name="pass">
        </div>  

        <div class="form-group input-group">
            <span class="input-group-addon"><i class="fa-solid fa-lock"></i></span>
            <input type="text" class="form-control" placeholder="Confirm-Password" name="cpass">
        </div>
        <?=$error?? null?>

       <div class="form-group">
           <label>Role:</label>
           <select class="form-control" name="role">
               <option>Admin</option>
               <option>Staff</option>
               <option>Receptionist</option>
           </select>
       </div>

    <button type="submit" name="add" class="btn btn-danger">ADD</button>
    <a href="staff-account.php" class="btn btn-danger justify-content-between">Back</a>
</form>
               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>


         <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
   
</body>
</html>
