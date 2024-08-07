<?php
require "../function/connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xsalon-Login</title>

    <!-- links -->

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/sign-in.css" rel="stylesheet">

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
    if (isset($_POST['ad-btn'])) {
        $user  = $_POST["user"];
        $email = $_POST["user"];
        $pass  = md5($_POST['pass']);

        if ($user == "") {
            $errors = "<p style='color:red'>Please fill all fields!.</p>";
        } else {
            // Checking user in database
            $query  = "SELECT * FROM `admin` WHERE `password` = '$pass' AND `username` = '$user';";
            $result = mysqli_query($con, $query);
            $count  = mysqli_num_rows($result);
            while ($data = mysqli_fetch_assoc($result)) {
                $id = $data['id'];
                $name = $data['username'];                
                $date = $data['date'];
                $role = $data['Role'];

            }

            if ($count == 1) {
                $_SESSION["admin"] = $role;
                $_SESSION["id"] = $id;                
                $_SESSION["date"] = $date;


                echo '<script>alert("Welcome ' . $name . '");window.location="adminpanel.php"</script>';
            } else {
                $error = "<p style='color:red'>Username or Password Incorrect!.</p>";
            }
        }
    }
    ?>
    <main class="form-signin w-100 m-auto">
        <form method="post">
            <img class="mb-4 rounded-circle shadow" src="../img/logo.png" alt="" width="72" height="67" style="object-fit: cover;">
            <h1 class="h3 mb-3 fw-normal center">Admin Panel</h1>
            <?= isset($errors) ? $errors : ""; ?>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="user">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pass">
                <label for="floatingPassword">Password</label>
            </div>
            <?= isset($error) ? $error : ""; ?>

            <div class="form-check text-start my-3">

            </div>
            <button class="btn btn-primary w-100 py-2" type="submit" name="ad-btn">Log In</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; <?= date("Y") ?></p>
        </form>
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>

</body>

</html>