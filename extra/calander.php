<?php


// $query = "SELECT * FROM `bookings` WHERE MONTH(`date`) = '?' AND YEAR(`date`) = '?'";
// $data = mysqli_query($con, $query);

// $bookings = array();

// if ($data) {
//     while ($row = mysqli_fetch_assoc($data)) {
//         $bookings[] = $row['date'];
//     }
//     mysqli_free_result($data);
// }
function build_calender($month, $year){
    require "../function/connection.php";
$stmt = $con->prepare('select  * from bookings where MONTH(date)=? AND YEAR(date)=?');
$stmt->bind_param('ss',$month,$year);
$bookings=array();
if($stmt->execute()){
    $result=$stmt->get_result();
    if($result->num_rows>0){
        while ($row=$result->fetch_assoc()) {
            $bookings[]=$row['date'];
    }
    $stmt->close();
}
}
    $daysOfWeek = array('Sunday','Monday','Tuesday','Wedneday','Thursday','Friday','Saturday');
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');

    $calender="<table class='table table-bordered'>";
    $calender.="<center><h2>$monthName $year</h2>";

    $prev_month = date('m',mktime(0,0,0,$month-1, 1,$year));
    $prev_year  = date('Y',mktime(0,0,0,$month-1, 1,$year));
    $next_month = date('m',mktime(0,0,0,$month+1, 1,$year));
    $next_year  = date('Y',mktime(0,0,0,$month+1, 1,$year));
    $calender.="<a class='btn btn-primary btn-xs m-1' href='?month=".$prev_month."&year=".$prev_year."'>Prev Month</a>";
    $calender.="<a class='btn btn-primary btn-xs m-1' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a>";
    $calender.="<a class='btn btn-primary btn-xs m-1' href='?month=".$next_month."&year=".$next_year."'>Next Month</a></center><br>";
    $calender.="<tr>";
    foreach($daysOfWeek as $day){
        $calender.="<th class='header'>$day</th>";
    }
    $calender .="</tr><tr>";
    $currentDay = 1;
    if($dayOfWeek > 0){
        for($k=1;$k<=$dayOfWeek;$k++){
            $calender.="<td class='empty'></td>";
    }
}
$month = str_pad($month,2,"0",STR_PAD_LEFT);
while($currentDay <= $numberDays){
    if($dayOfWeek == 7){
        $dayOfWeek = 0;
        $calender.="</tr><tr>";
    }

    $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
    $date = "$year-$month-$currentDayRel";
    $dayName = strtolower(date('l',strtotime($date)));
    $today = $date==date('Y-m-d')? 'today' : "";
    if(in_array($date, $bookings)){
        $calender.="<td class='$today'><h4>$currentDay</h4><a class='btn btn-danger btn-xs'>Booked</a></td>";
    }else{
        $calender.="<td class='$today'><h4>$currentDay</h4><a class='btn btn-success btn-xs'>Book</a></td>";

    }
    $currentDay++;
    $dayOfWeek++;
}

if($dayOfWeek<7){
    $remainingDays = 7 - $dayOfWeek;
    for($j=1;$j<= $remainingDays;$j++){
        $calender .= "<td class='empty'></td>";
}
}

$calender.="</tr></table>";
return $calender;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>calander</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {
        /* force table to not be like table anymore */
        table,
        thead,
        tbody,
        th,
        td,
        tr{
            display: block;
        }

        .empty{
            display: none;
        }
        /* Hide table header (but not display: none;, for accessibility) */
        th {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        tr {
            border: 1px solid #ccc;
        }
        td{
            /* behave like a row */
            border:none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }
        /* label the data */
        td:nth-of-type(1):before {
            content:"Sunday";
        }
        td:nth-of-type(2):before {
            content:"Monday";
        }
        td:nth-of-type(3):before {
            content:"Tuesday";
        }
        td:nth-of-type(4):before {
            content:"Wednesday";
        }
        td:nth-of-type(4):before {
            content:"Thursday";
        }
        td:nth-of-type(4):before {
            content:"Friday";
        }
        td:nth-of-type(4):before {
            content:"Saturday";
        }
    }
    /* smartphone (portrait and landscape) */
    @media only screen and (min-device-width : 320px) and (max-device-width : 480px){
        body{
            padding: 0;
            margin: 0;
        }
    }
    /* ipads (potrait and landscape) */
    @media only screen and (min-device-width: 768px) and (max-device-width: 1024){
        body{
            width: 495px;
        }
    }
    @media (min-width:641px){
        table {
            table-layout: fixed;
        }
        td{
            width: 33%;
        }
    }
    .row{
        margin-top: 20px;
    }
    .today{
        background: yellow ;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $dateComponents = getdate();
                // echo "<h1>".$dateComponents['mday']."/".$dateComponents['mon']."/".$dateComponents['year']."</h1>";
                if(isset($_GET['month']) && isset($_GET['year'])){
                    // current
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                }
                echo build_calender($month,$year);

                ?>
            </div>
        </div>
    </div>
</body>
</html>