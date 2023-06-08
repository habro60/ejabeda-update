<?php
//include connection file 
require "../auth/auth.php";
require "../database.php";
include_once('pdf/fpdf.php');
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    // $this->Image('0.jpg',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(70,10,'Kazi Abdul Hamid College',1,0,'C');
    // Line break
    $this->Ln(20);

    


}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$display_heading = array('member_id'=>'Member_id', 'full_name'=> 'Full Name', 'email'=> 'Email','mobile'=> 'Mobile','annul_c_tk'=> 'Annual Paid TK');
 
$result = mysqli_query($conn, "SELECT member_id, full_name, email, email, mobile, annul_c_tk FROM member") or die("database error:". mysqli_error($conn));
$header = mysqli_query($conn, "SHOW columns FROM member WHERE field != 'id' and field !='member_type' and field !='father_name' and field !='mother_name' and field !='husband_name ' and field !='nid_birth_no ' and field !='passport_no ' and field !='blood_group ' and field !='dob ' and field !='village ' and field !='division ' and field !='district' and field !='upazila ' and field !='p_office ' and field !='p_code ' and field !='p_village ' and field !='p_division ' and field !='p_district ' and field !='p_upazila ' and field !='p_p_office ' and field !='p_p_code ' and field !='donation_type ' and field !='payment_type ' and field !='referred_person_type' and field !='referred_person_id ' and field !='referred_person ' and field !='annual_con_in_fc ' and field !='currency_type ' and field !='currency_rate ' and field !='activation_key ' and field !='paid_amount' and field !='paid_date ' and field !='due ' and field !='created_by ' and field !='created_date ' and field !='modify_by ' and field !='modify_date '");
 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);

$pdf->Cell(25,10,$display_heading['member_id'],1);
$pdf->Cell(35,10,$display_heading['full_name'],1);
$pdf->Cell(60,10,$display_heading['email'],1);
$pdf->Cell(30,10,$display_heading['mobile'],1);
$pdf->Cell(35,10,$display_heading['annul_c_tk'],1);

foreach($result as $row) {
    $pdf->SetFont('Arial','',10);
    $pdf->Ln();
    $pdf->Cell(25,10,$row['member_id'],1);
    $pdf->Cell(35,10,$row['full_name'],1);
    $pdf->Cell(60,10,$row['email'],1);
    $pdf->Cell(30,10,$row['mobile'],1);
    $pdf->Cell(35,10,$row['annul_c_tk'],1);
    }
$pdf->Output();
?>