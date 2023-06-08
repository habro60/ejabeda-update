<?php
require "../auth/auth.php";
require "../database.php";
require('fpdf.php');

if (isset($_POST['addVehicleEntry'])) {

    $vehicle_type = $_POST['vehicle_type'];
    $car_reg_no = $_POST['car_reg_no'];
    $ss_creator = $_SESSION['username'];
    $ss_modifier = $_SESSION['username'];

    // $car = "SELECT car_reg_no FROM parking_lots_info
    // WHERE car_reg_no='$car_reg_no';";
    $car = "SELECT car_reg_no FROM parking_lots_info
    WHERE car_reg_no LIKE '%$car_reg_no%'";

$carResulr= mysqli_query($conn, $car) or die( mysqli_error($conn));

$result23=mysqli_fetch_assoc($carResulr);


// $a=strval($result23['car_reg_no']);

// $b=strval($car_reg_no);

//isset($result23['car_reg_no'])

    if (isset($result23)) {
        # code...
        //echo $car_reg_no;
        //echo "It is Resident Car No";
        echo '<script>alert("It is Resident Car No")</script>';
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=../vehicles_in\">";
    }else {
        
    $query2 = "INSERT INTO `car_mov_reg`(`vehicle_type`,`car_reg_no`,`ss_creator`,`ss_modifier`) VALUES ('$vehicle_type','$car_reg_no','$ss_creator','$ss_modifier')";

    $result = mysqli_query($conn, $query2) or die( mysqli_error($conn));


    // $in_time_query = "SELECT * FROM car_mov_reg";

    // $in_time_result = mysqli_query($conn, $in_time_query) or die( mysqli_error($conn));
    // $in_time_result2=mysqli_fetch_assoc($in_time_result);

    //$_SESSION['separate_date_time']=date('d-M-y g:i a', strtotime($in_time_result2['in_time']));


    // if ($result) {
    //     # code...
    //     echo $car_reg_no;
    //     echo "2";
       
    // }

   // echo $car;


    //  $query3 = "SELECT car_mov_reg.*, parking_lots_info.car_reg_no FROM car_mov_reg LEFT JOIN parking_lots_info ON car_mov_reg.car_reg_no=parking_lots_info.id ORDER BY id DESC LIMIT 1";

    $query3 = "SELECT car_mov_reg.car_reg_no,car_mov_reg.id,car_mov_reg.in_time FROM car_mov_reg WHERE car_reg_no='$car_reg_no' ORDER BY id DESC LIMIT 1";

    $pdfresult = mysqli_query($conn, $query3) or die( mysqli_error($conn));
    $result2=mysqli_fetch_assoc($pdfresult);

    $time=date('d-M-y g:i a', strtotime($result2['in_time']));

    

// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Output();

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

    $pdf->SetFont("Arial","","10");
    $pdf->Ln(10);
    $pdf->Cell(-30);
   
    $pdf->Cell(90,5,"Entry Date & Time",0,1,'C');
    $pdf->Ln(-8);
    $pdf->Cell(45);
    
    $pdf->Cell(45,10,$time,0,1);
    //$pdf->Cell(45,10,$result2['in_time'],0,1);

    $pdf->SetFont("Arial","","10");
    $pdf->Ln(12);
    $pdf->Cell(-30);
    $pdf->Cell(85,5,"Token NO",0,1,'C');
    $pdf->Ln(-8);
    $pdf->Cell(45);
    $pdf->SetFont("Arial","B","25");
    $pdf->Cell(45,10,$result2['id'],0,1);

    $pdf->SetFont("Arial","","10");
    $pdf->Ln(12);
    $pdf->Cell(-30);
    $pdf->Cell(88,5,"Vehicle NO",0,1,'C');
    $pdf->Ln(-8);
    $pdf->Cell(45);
    $pdf->Cell(45,10,$result2['car_reg_no'],0,1);


    
    $pdf->SetFont("Arial","I","7");
    // $pdf->Ln(1);
    // $pdf->SetX(20);
    //$pdf->SetAutoPageBreak(12);
    $pdf->Cell(80,5,"Developed & Maintenanced By",0,1,'C');
    $pdf->Cell(80,5,"Habro System Limited",0,1,'C');
    $pdf->Cell(80,5,"Dhaka, Bangladesh",0,1,'C');

    // $pdf->Cell(20,10,"Token",1,0);
    // $pdf->Cell(45,10,"IN TIME",1,0);

    // $pdf->Cell(20,10,$result2['id'],1,0);
    // $pdf->Cell(45,10,$result2['in_time'],1,0);

    $file = time() .'.pdf';
    $pdf->OutPut($file,'I');
    //$pdf->OutPut($file,'D');
    }

}

?>