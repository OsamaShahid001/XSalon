<?php
require "../function/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xsalon-Signup</title>

    <!-- links -->
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/sign-in.css">
</head>
<style>
  .body {
    color: #D5B981;
  }

  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  .b-example-divider {
    width: 100%;
    height: 3rem;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
  }

  .b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
  }

  .bi {
    vertical-align: -.125em;
    fill: currentColor;
  }

  .nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
  }

  .nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
  }

  .btn-bd-primary {
    --bd-violet-bg: #712cf9;
    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

    --bs-btn-font-weight: 600;
    --bs-btn-color: var(--bs-white);
    --bs-btn-bg: var(--bd-violet-bg);
    --bs-btn-border-color: var(--bd-violet-bg);
    --bs-btn-hover-color: var(--bs-white);
    --bs-btn-hover-bg: #6528e0;
    --bs-btn-hover-border-color: #6528e0;
    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
    --bs-btn-active-color: var(--bs-btn-hover-color);
    --bs-btn-active-bg: #5a23c8;
    --bs-btn-active-border-color: #5a23c8;
  }

  .bd-mode-toggle {
    z-index: 1500;
  }

  .bd-mode-toggle .dropdown-menu .active .bi {
    display: block !important;
  }
</style>
<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <?php
    if (isset($_POST['back'])) {
        header("location: login.php");
    }
    ?>

    <?php
  $error = null;
  $errors = null;

  if (isset($_POST['sg-up-btn'])) {
    $user      = trim($_POST["username"]);
    $email     = trim($_POST["email"]);
    $password  = md5($_POST["password"]);
    $cpassword = md5($_POST["confirm-password"]);
    $image     = 'img/user-default.png';

    if (!empty($password == $cpassword)) {
      // If user already exists in the database show error message and don't insert new user
      $query = "SELECT * FROM `users` WHERE `name` ='$user'";
      $result = mysqli_query($con, $query);
      $count = mysqli_num_rows($result);

      if ($count > 0) {
        $errors = "<p style='color:red'>Username Or Email Already Exists.</p>";
      } else {
        $query = "INSERT INTO `users`(`name`, `email`, `password`, `image`) VALUES ('$user','$email','$password','$image')";
        $result = mysqli_query($con, $query);

        if ($result) {
          echo "<script>alert('Thanks for signing up!:)');window.location='login.php';</script>";
        }
      }
    } else {
      $error = "<p style='color:red'>Password did not match.</p>";
    }
  }
  ?>
  <form method="post">
    </form>
  <main class="form-signin w-100 m-auto">

    <form method="post">
      <img class="mb-4 rounded-circle shadow" src="../img/logo.png" alt="" width="72" height="67" style="object-fit: cover;">
      <h1 class="h3 mb-3 fw-normal center">Please sign Up</h1>

      <?= $errors ?>

      <!-- username -->
      <div class="form-floating">
        <input type="text" class="form-control" id="floatinginput" placeholder="Username" name="username">
        <label for="floatinginput">Username</label>
      </div>
      <!-- email -->
      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
        <label for="floatingInput">Email address</label>
      </div>
      <!--Password -->
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="password" name="password">
        <label for="floatingInput">password</label>
      </div>

      <!--Confirm-Password -->
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="confirm-Password" name="confirm-password">
        <?= $error ?>
        <label for="floatingPassword">confirm-Password</label>
      </div>


      <div class="my-2 mt-3" style="text-align: left;">Already have an account? <a class="text-danger" href="login.php">Login Here</a></div>

      <button class="btn btn-danger w-100 py-2" type="submit" name="sg-up-btn">Sign Up</button>
      <button class= 'btn btn-light w-100 py-2 mt-1' name="back">Back</button>

      <p class="mt-5 mb-3 text-body-secondary">&copy; <?= date("Y") ?></p>
    </form>
  </main>

  <script src="../js/bootstrap.bundle.min.js"></script>

</body>

</html>
