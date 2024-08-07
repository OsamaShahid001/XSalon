<?php
require_once "../function/connection.php";
?>
<?php
$date = date('Y-m-d');
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}

$existingTimes = [];
$query = "SELECT time FROM `bookings` WHERE `date` = '$date' ";
$result = mysqli_query($con, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $existingTimes[] = $row['time'];
    }
}

function get_times($default = '12:00', $interval = '+60 minutes', $existingTimes = [])
{
    $output = '';
    $current = strtotime('12:00');

    // Set the end time to 6:00 PM
    $end = strtotime('18:00');

    // Check if $existingTimes array is empty
    if (empty($existingTimes)) {
        // Default behavior when $existingTimes is empty
        while ($current <= $end) {
            $time = date('g:i', $current);
            $color_avail = ($time) ? ' style="color: green;"' : '';
            $sel = ($time == $default) ? ' selected' : '';
            $output .= "<option value=\"{$time}\"{$sel}{$color_avail}>" . date('g.i A', $current) . '</option>';
            $current = strtotime($interval, $current);
        }
    } else {
        // Behavior when $existingTimes has values
        while ($current <= $end) {
            $time = date('g:i', $current);
            $sel = ($time == $default) ? ' selected' : '';
            $isBooked = in_array($time, $existingTimes);
            $disabled = ($isBooked) ? ' disabled' : '';
            $color = ($isBooked) ? ' style="color: red;"' : '';
            $color_avail = ($time) ? ' style="color: green;"' : '';
            $output .= "<option value=\"{$time}\"{$sel}{$disabled}{$color}{$color_avail}>" . date('g.i A', $current) . '</option>';
            $current = strtotime($interval, $current);
        }
    }

    return $output;
}

$dropdown = get_times('12:00', '+60 minutes', $existingTimes);



// if (isset($_POST['submit'])) {
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $stmt = $con->prepare("INSERT INTO bookings (name, email, date) VALUES (?,?,?)");
//     $stmt->bind_param('sss', $name, $email, $date);
//     $stmt->execute();
//     $msg = "<div class='alert alert-success'>Booking Successfull</div>";
//     $stmt->close();
//     $mysqli->close();
// }

// if (isset($_POST['submit'])) {
//     $name = trim($_POST['name']);
//     // $email = $_POST['email'];
//     $email = "babar@gmail.com";
//     $services = $_POST['services'];
//     $time = $_POST['time'];
// echo $name;
//     $query = "SELECT `date` FROM `bookings` WHERE `time` = '$time'";
//     $result = mysqli_query($con,$query);
//     $count = mysqli_num_rows($result);
//     // if($count > 0) {
//     //     header("location: calander copy.php");
//     // }else{

//     $query = "INSERT INTO `bookings`(`date`, `time`, `name`, `email`, `services`) VALUES ('$date','$time','$name','$email','$services')";
//     $result = mysqli_query($con,$query);
//     if($result){
//         echo "Booked Appointment";
//     }
//     // echo $date;
//     // echo $name;
//     // echo $email;
//     // echo $services;
//     // echo $time;
// }
// $email = "babar@gmail.com";

// 
?>



    <section id="form" class="container">
        <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1>
        <hr>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php echo isset($msg) ? $msg : ''; ?>
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="" disabled class="form-control" value="<?= $email ?>" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Services</label>
                        <select name="services" id="">
                            <option value="Hair Cut">Hair Cut</option>
                            <option value="Hair Wash">Hair Wash</option>
                            <option value="Hair Color">Hair Color</option>
                            <option value="Hair Shave">Hair Shave</option>
                            <option value="Hair Straight">Hair Straight</option>
                            <option value="Facial">Facial</option>
                            <option value="Shampoo">Shampoo</option>
                            <option value="Beard Trim">Beard Trim</option>
                            <option value="Beard Shave">Beard Shave</option>
                            <option value="Wedding Cut">Wedding Cut</option>
                            <option value="Clean Up">Clean Up</option>
                            <option value="Massage">Massage</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Time</label>
                        <?php echo '<select name="time">' . $dropdown . '</select>'; ?>
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                    <button class="btn btn-primary " type="back" name="submit">Back</button>
                </form>
            </div>
        </div>
    </section>
    <?php
    if (isset($_POST['submit'])) {

        $services = $_POST['services'];
        $price = 0;
        switch ($services) {
            case "Hair Cut":
                $price = 9.99;
                break;
            case "Hair Wash":
                $price = 10.99;
                break;
            case "Hair Color":
                $price = 11.99;
                break;
            case "Hair Shave":
                $price = 12.99;
                break;
            case "Hair Straight":
                $price = 13.99;
                break;
            case "Facial":
                $price = 14.99;
                break;
            case "Shampoo":
                $price = 15.99;
                break;
            case "Beard Trim":
                $price = 16.99;
                break;
            case "Beard Shave":
                $price = 17.99;
                break;
            case "Wedding Cut":
                $price = 18.99;
                break;
            case "Clean Up":
                $price = 19.99;
                break;
            case "Massage":
                $price = 20.99;
                break;
        }
        
        echo "booking id:".rand(1,1000)."<br>" .$services . "= $" . $price;
    }
    ?>

