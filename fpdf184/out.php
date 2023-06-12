<?php

require "../auth/auth.php";
require "../database.php";
require('fpdf.php');


function timeago($datetime, $full = false) {
    date_default_timezone_set('Asia/Dhaka');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
    'y' => 'yr',
    'm' => 'mon',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hr',
    'i' => 'min',
    's' => 'sec',
    );
    foreach ($string as $k => &$v) {
    if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } 
    else {
        unset($string[$k]);
    }
    }
    if (!$full) {
    $string = array_slice($string, 0, 1);
    }
    
    return $string ? implode(', ', $string) . '' : 'just now';
}





if (isset($_POST['updateOutVehicle'])) {

    $id   = $_POST['id'];
    $car_reg_no  = $_POST['car_reg_no'];
   
// echo $taka;
    //$in_time = timeago($_POST['in_time']);
    
    
    $status=$_POST['status'];
    $ss_creator = $_SESSION['username'];
    $ss_modifier = $_SESSION['username'];

    //$netTime=$in_time-$time_out;

    // if ($total_parking_cost>0) {
    //     $total_parking_cost=40;
    // }
    // if ($total_parking_cost>$in_time) {
    //     $total_parking_cost=40;
    // }

    //  print_r($in_time);
   
    //  exit;

    $query3 = "UPDATE `car_mov_reg` SET `status`='$status',`ss_creator`='$ss_creator',`ss_modifier`='$ss_modifier' WHERE  `id`='$id'";
    
    mysqli_query($conn, $query3) or die( mysqli_error($conn));

    // parking cost and time difference anar jonno query start


    $ret=("SELECT id,in_time,out_time,total_parking_cost,vehicle_type, CONCAT( FLOOR(HOUR(TIMEDIFF(`in_time`,`out_time`)) / 24), ' DAYS ',MOD(HOUR(TIMEDIFF(`in_time`,`out_time`)), 24), ' HOURS ',
    MINUTE(TIMEDIFF(`in_time`,`out_time`)), ' MINUTES ') AS difference from car_mov_reg where id='$id'");


$selectQueryEditResult = $conn->query($ret);
$rows = $selectQueryEditResult->fetch_assoc();

$date= $rows['in_time'];
$date2= $rows['out_time'];
$time_diff= $rows['difference'];
$vehicle_type= $rows['vehicle_type'];

$query12 = "SELECT * FROM parking_rate_setup WHERE id='$vehicle_type'";

$result12 = mysqli_query($conn, $query12) or die( mysqli_error($conn));

$row12 = mysqli_fetch_assoc($result12);
$v_amount=$row12['first_hr_rate'];

if ($time_diff<'0 DAYS 0 HOURS 60 MINUTES') {
// echo "ek gontar kom 20 taka";
// echo ( strtotime($date2) - strtotime($date))/3600;
$taka = $v_amount;
//  echo 20, " TK";
}elseif ($time_diff<'24 HOURS 60 MINUTES') {
//echo "ek gontar beshi 40 taka";
//echo strtotime($date)-strtotime($date2);
$hour = (strtotime($date2) - strtotime($date)) / 3600*$v_amount;
$hour2 = number_format((float)$hour, 0, '.', '');
$taka = $hour2;

//   echo $taka;

//echo (strtotime($date2) - strtotime($date)) / 3600*20;
// echo number_format((float)$hour, 0, '.', '')," TK";
//echo round((strtotime($date2)-strtotime($date))/3600);
//echo "my result is: $hour_diff.";
}elseif ($time_diff < '30 DAYS 24 HOURS 60 MINUTES') {
echo "ek din beshi 4000 taka";
}else {
echo "ek month er beshi 00 taka";
}

$query3 = "UPDATE `car_mov_reg` SET `total_parking_cost`='$taka',`difference`='$time_diff',`ss_creator`='$ss_creator',`ss_modifier`='$ss_modifier' WHERE  `id`='$id'";
    
mysqli_query($conn, $query3) or die( mysqli_error($conn));

$time_diffs= substr($rows['difference'],7,35);

// parking cost and time difference anar jonno query end


$query3 = "SELECT car_mov_reg.car_reg_no,car_mov_reg.id,car_mov_reg.in_time,car_mov_reg.out_time,car_mov_reg.total_parking_cost FROM car_mov_reg WHERE car_reg_no='$car_reg_no' ORDER BY id DESC LIMIT 1";

    $pdfresult = mysqli_query($conn, $query3) or die( mysqli_error($conn));
    $result2=mysqli_fetch_assoc($pdfresult);
// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Output();
$date=$result2['in_time'];
$time=timeago($date);

$in_time=date('d-M-y g:i a', strtotime($result2['in_time']));
$out_time=date('d-M-y g:i a', strtotime($result2['out_time']));



$pdf = new FPDF('P','mm',array(100,130));
$pdf->AddPage();
$pdf->Image('habro-logo.png',7,10,8,0,'png');
$pdf->SetFont("Arial","","17");
$pdf->Cell(80,5,"Habro System LIMITED",0,1,'C');
$pdf->Ln(1);
$pdf->SetFont("Arial","","15");
$pdf->Cell(80,5,"Car Parking Entry Slip",0,1,'C');
$pdf->Ln(1);
$pdf->SetFont("Arial","","12");
$pdf->Cell(80,5,"Gulshan Dhaka",0,1,'C');
//$pdf->Cell(90,5,"Habro System LIMITED",1,1,'C');
$pdf->Ln(1);


// Token start

$pdf->SetFont("Arial","","10");
$pdf->Ln(4);
$pdf->Cell(-30);
$pdf->Cell(78,5,"Token NO",0,1,'C');
$pdf->Ln(-8);
$pdf->Cell(45);
$pdf->Cell(45,10,$result2['id'],0,1);

// Token end

// vehicle start

$pdf->SetFont("Arial","","10");
$pdf->Ln(4);
$pdf->Cell(-30);
$pdf->Cell(80,5,"Vehicle NO",0,1,'C');
$pdf->Ln(-8);
$pdf->Cell(45);
$pdf->Cell(45,10,$result2['car_reg_no'],0,1);

// vehicle end

// Date & Time start

    $pdf->SetFont("Arial","","10");
    $pdf->Ln(4);
    $pdf->Cell(-30);
   
    $pdf->Cell(90,5,"Entry Date & Time",0,1,'C');
    $pdf->Ln(-8);
    $pdf->Cell(45);
    // $pdf->SetLineWidth(.1);
    // $pdf->SetMargins(11, 7); 
    $pdf->Cell(45,10,$in_time,0,1);
    //$pdf->Cell(45,10,$result2['in_time'],0,1);

    // Date & Time end

// Exit Date & Time start

    $pdf->SetFont("Arial","","10");
    $pdf->Ln(4);
    $pdf->Cell(-30);
   
    $pdf->Cell(88,5,"Exit Date & Time",0,1,'C');
    $pdf->Ln(-8);
    $pdf->Cell(45);
    // $pdf->SetLineWidth(.1);
    // $pdf->SetMargins(11, 7); 
    $pdf->Cell(45,10,$out_time,0,1);
    //$pdf->Cell(45,10,$result2['in_time'],0,1);

    // Exit Date & Time end

    // Duration start

    $pdf->SetFont("Arial","","10");
    $pdf->Ln(4);
    $pdf->Cell(-30);
   
    $pdf->Cell(75,5,"Duration",0,1,'C');
    $pdf->Ln(-8);
    $pdf->Cell(45);
    // $pdf->SetLineWidth(.1);
    // $pdf->SetMargins(11, 7);
    
    $pdf->Cell(45,10,$time_diffs,0,1);

    // Duration end


    // TK start

    $pdf->SetFont("Arial","B","10");
    $pdf->Ln(4);
    $pdf->Cell(-30);
    $pdf->Cell(78,5,"TK.",0,1,'C');
    $pdf->Ln(-8);
    $pdf->Cell(45);
    $pdf->SetFont("Arial","B","25");
    $pdf->Cell(45,10,$result2['total_parking_cost'],0,1);

    // TK end

    // footer start
    
    $pdf->SetFont("Arial","I","7");
    // $pdf->Ln(1);
    // $pdf->SetX(20);
    //$pdf->SetAutoPageBreak(12);
    $pdf->Cell(70,5,"Developed & Maintenanced By",0,1,'C');
    $pdf->Cell(70,5,"Habro System Limited",0,1,'C');
    $pdf->Cell(70,5,"Dhaka, Bangladesh",0,1,'C');

// footer end
   

    $file = time() .'.pdf';
    $pdf->OutPut($file,'I');
    //$pdf->OutPut($file,'D');


    //header("location:index.php");
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
    
}