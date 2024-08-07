<?php
require "../../function/connection.php";
session_start();
if ($_SESSION["admin"] == null) {
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
                <a class="navbar-brand" href="../adminpanel.php"><?= $name ?></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;">
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
                    <?php if($_SESSION["admin"] == 'Staff' or $_SESSION["admin"] == 'Receptionist'){
                        
                    }else if($_SESSION["admin"] == 'Admin'){
                         echo '<li>
                                   <a href="../users-control/users-account.php"><i class="fa fa-user fa-3x"></i> User Accounts</a>
                               </li>';
                         echo '<li>    
                                   <a href="../staff-control/staff-account.php"><i class="fa fa-users fa-3x"></i> Staff Accounts</a>
                               </li>';  
                         echo '<li>
                                   <a class="active-menu" href="inventory.php"><i class="fa fa-qrcode fa-3x"></i> Inventory</a>
                              </li>';   
                   }

                   if($_SESSION["admin"] == 'Receptionist'){
                       echo '<li>
                              <a href="inventory.php"><i class="fa fa-qrcode fa-3x"></i> Inventory</a>
                          </li>';}
               ?>
           </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->
        <?php
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $query = "select * from `inventory` where id = $id";
    $data = mysqli_query($con, $query);
    while($result   = mysqli_fetch_assoc($data)){
        $ename      = $result['product_name'];
        $esku       = $result['product_sku'];        
        $ewholesaler= $result['wholesaler'];
        $ecatg      = $result['category'];
        $eimg       = $result['image'];
        $eno      = $result['inventory'];
        $eprice     = $result['price'];
   }
}

?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Inventory Update</h2>   
                        <h5>Welcome <?= $fname ?> , Love to see you back. </h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
<?php
if (isset($_POST["btn"])) {
    $name       = trim($_POST["name"]);
    $sku        = trim($_POST["sku"]);
    $wholesaler = trim($_POST["wholesaler"]);
    $catg       = trim($_POST["catg"]);
    $eno        = trim($_POST["eno"]);
    $price        = trim($_POST["price"]);
    $eimg = explode('/',$eimg);


 if(!empty($name) && !empty($sku)){
    if (isset($_FILES['image'])) {
        $filename  = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        move_uploaded_file($file_tmp, "../assets/imgs/" . $filename);
    }

    if(empty($filename)){
    $filename = $eimg[2];
    }

    $query = "UPDATE `inventory` SET `product_name`='$name',`product_sku`='$sku',`wholesaler`='$wholesaler',`category`='$catg',`image`='assets/imgs/$filename',`inventory`='$eno',`price`='$price' WHERE `id` = '$id'";
    $result =  mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Product Update');window.location='inventory.php'</script>";
    } else {
        echo "<script>alert('Product Not Update')</script>";
    }
}else{
$error =  "<div class='alert alert-danger'>Please Enter Product <strong>Name</strong> & <strong>Sku</strong> of Product!</div>";
}}
?>
    <h2><?=$ename?> Update</h2>
    <?=$Error ?? null?>
    <form method="post" enctype="multipart/form-data">
                            <h3>Please Enter Product Details:</h3>
                            <?=$error ?? null ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa-brands fa-product-hunt"></i></span>
                                <input type="text" class="form-control" placeholder="Product Name" value="<?=$ename?>" name="name">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa-solid fa-hashtag"></i></span>
                                <input type="text" class="form-control" placeholder="Product Sku" value="<?=$esku?>" name="sku">
                            </div>

                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa-solid fa-universal-access"></i></span>
                                <input type="text" class="form-control" placeholder="Wholesaler Name" value="<?=$ewholesaler?>" name="wholesaler">
                            </div>

                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa-solid fa-table-list"></i></span>
                                <input type="text" class="form-control" placeholder="category" value="<?=$ecatg?>" name="catg">
                            </div>                            
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa-solid fa-warehouse"></i></span>
                                <input type="number" class="form-control" placeholder="Units" value="<?=$eno?>" name="eno">
                            </div>
                            <span class="input-group">Please Select Image:</span>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa-solid fa-file"></i></span>
                                <input type="file" class="form-control" name="image">
                            </div>                            
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa-solid fa-dollar"></i></span>
                                <input type="number" step=any class="form-control" placeholder="Units" value="<?=$eprice?>" name="price">
                            </div>
                            <button type="submit" name="btn" class="btn btn-danger">Update</button>
                            <a href="inventory.php" class="btn btn-danger justify-content-between">Back</a>
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
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
   
</body>
</html>
