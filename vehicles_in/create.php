<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
//require '../source/sidebar.php';
require '../source/header.php';

if (isset($_POST['addVehicleEntry'])) {

    $vehicle_type = $_POST['vehicle_type'];
    $car_reg_no = $_POST['car_reg_no'];
    $ss_creator = $_SESSION['username'];
    $ss_modifier = $_SESSION['username'];

    $query2 = "INSERT INTO `car_mov_reg`(`vehicle_type`,`car_reg_no`,`ss_creator`,`ss_modifier`) VALUES ('$vehicle_type','$car_reg_no','$ss_creator','$ss_modifier')";
    
    $result = mysqli_query($conn, $query2) or die( mysqli_error($conn));

    
    

//     header("Content-disposition: attachment; filename=document.pdf");
// header("Content-type: application/pdf");


require('../fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
    
    


    // $pdf = new FPDF();
    // $pdf->AddPage();
    // $pdf->SetFont("Arial","","16");
    // $pdf->Cell(0,10,"reg Dtail",1,1,'C');

    // $pdf->Cell(20,10,"car_reg_no",1,0);
    // $pdf->Cell(45,10,"vehicle_type",1,0);

    // $pdf->Cell(20,10,$car_reg_no,1,0);
    // $pdf->Cell(45,10,$vehicle_type,1,0);

    // $file = time() .'.pdf';
    // $pdf->OutPut($file,'D');


    
    // $pdf = new FPDF();
    // $pdf->AddPage();
    // $pdf->SetFont('Arial','B',16);
    // $pdf->Cell(40,10,'Hello World!');
    // $pdf->Output();
   

    // if ($result) {
    //     $success = "Data Save Successfully!..";
    // }else{
    //     $error = "Data Not Save!..";
    // }

    //header('location:/carparking/index.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=../vehicles_in/\">";
    
}