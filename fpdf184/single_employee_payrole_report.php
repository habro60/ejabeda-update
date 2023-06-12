<?php

use Pdf as GlobalPdf;

require "../auth/auth.php";
require "../database.php";
require('fpdf.php');


class PDF extends FPDF
	{
		// Load data


		// Simple table
		function BasicTable($header)
		{
		    // Header
		    foreach($header as $col)
		        $this->Cell(30,15,$col,2);
		    	$this->Ln();
		    // Data
		   
		}


      function FancyTable($header,$a,$b,$c,$d,$e,$f,$g,$h,$emp_serial,$k,$l)
{
	// Colors, line width and bold font
	$this->SetFillColor(255,255,204);
	$this->SetTextColor(0);
	$this->SetDrawColor(192,192,192);
	$this->SetLineWidth(.2);
	$this->SetFont('','B');
	// Header
	$w = array(20, 35, 37, 30,25,25,20);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],12,$header[$i],2,0,'C',true);
	$this->Ln();
	// Color and font restoration
	// $this->SetFillColor(128,0,0);
	$this->SetTextColor(0);
	$this->SetFont('');
	// Data
   $i=0;
   $key=0;
	$fill = false;
   $size=sizeof($a);
 
while($size>0){

    if($i==$emp_serial){
        $this->Cell($w[0],6,$a[$i],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$b[$i],'LR',0,'L',$fill);
		$this->Cell($w[2],6,$c[$i],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$d[$i],'LR',0,'R',$fill);
		$this->Cell($w[4],6,$e[$i],'LR',0,'R',$fill);
		$this->Cell($w[5],6,$f[$i],'LR',0,'R',$fill);
      $this->Cell($w[6],6,$g[$i],'LR',0,'R',$fill);
$key=$i;
		$this->Ln();
		$fill = !$fill;
    }

     
      $i++;
      $size--;
      
}
$this->Ln(5);
$this->Cell(192,6,$g[$key],'LR',0,'R',$fill);
$this->Cell(-70, 5, 'Total Netpay ', 0, 0, 'C');
$this->Ln(20);
$this->Cell(350, 5, 'Signature:.......................', 0, 0, 'C');
	// foreach($a as $row)
	// {
	// 	$this->Cell($w[0],6,$a,'LR',0,'L',$fill);
	// 	$this->Cell($w[1],6,$b,'LR',0,'L',$fill);
	// 	$this->Cell($w[2],6,number_format($c),'LR',0,'R',$fill);
	// 	$this->Cell($w[3],6,number_format($d),'LR',0,'R',$fill);
	// 	$this->Ln();
	// 	$fill = !$fill;
	// }
	//Closing line
	$this->Cell(array_sum($w),0,'','T');
   
}
   }


$pdf = new PDF();

if (isset($_SESSION['current_date'])) {

   // $select_month = $conn->escape_string($_SESSION['select_month']);
   $date= $_SESSION['current_date'];



$sql = "SELECT sm_hr_emp.emp_id,sm_hr_emp.f_name,sm_hr_emp.desig_code,hr_desig.desig_desc,hr_desig.grade_code FROM sm_hr_emp INNER JOIN hr_desig ON hr_desig.desig_code=sm_hr_emp.desig_code";
$emp_serial =$_GET['id'];
$query = $conn->query($sql);
$a = [];
$b = [];
$c = [];
$d = [];
$e = [];
$f = [];
$g = [];
$h = [];
$k = [];
$l = [];
$t_net_p=0;
while ($row = $query->fetch_assoc()) {
 $emp_desig_code=$row['desig_code'];
 $emp_id=$row['emp_id'];
 $total_allowance=0;
 $total_dedaction=0;
 global $last_scale;
 $last_scale=0;
 $year_diff="select
 YEAR(' $date') - YEAR(sm_hr_emp.join_date) AS year_diff 
 from sm_hr_emp  WHERE sm_hr_emp.emp_id='$emp_id'";
 $query2 = $conn->query($year_diff);
 $y_diff_row = $query2->fetch_assoc();
 $y_diff=($y_diff_row['year_diff']+1);

if($y_diff<=0){
$last_scale=0;
}else{

$sql1 = "SELECT hr_pscale_setup.last_pay_amt FROM hr_pscale_setup WHERE hr_pscale_setup.increment_slno='$y_diff' AND hr_pscale_setup.desig_code='$emp_desig_code'";

//use for MySQLi-OOP
 $query3 = $conn->query($sql1);
 $last_scale_row = $query3->fetch_assoc();
 if(isset($last_scale_row['last_pay_amt'])==''){

   $last_scale=0;


 }else{
   $last_scale=$last_scale_row['last_pay_amt'];
 }
 
}
 






 $sql2 = "SELECT hr_allowance_setup.allowance_type,hr_allowance_setup.allowance_amt FROM hr_allowance_setup WHERE hr_allowance_setup.desig_code='$emp_desig_code' ";

 //use for MySQLi-OOP
   $query4 = $conn->query($sql2);

   while( $total_allowance_row = $query4->fetch_assoc()){
     if($total_allowance_row['allowance_type']=='fixed'){

       $total_allowance=$total_allowance + $total_allowance_row['allowance_amt'];
      
     }elseif($total_allowance_row['allowance_type']=='percentage'){
       $result=(($total_allowance_row['allowance_amt']*$last_scale))/100;
       $total_allowance=$total_allowance+ $result;
       

     }

   }
   
  
   $sql3 = "SELECT hr_deduction_setup.deduction_type,hr_deduction_setup.deduction_amt ,hr_deduction_setup.deduction_desc FROM hr_deduction_setup WHERE hr_deduction_setup.desig_code='$emp_desig_code'";


   $query5 = $conn->query($sql3);
  

   while( $total_dedaction_row = $query5->fetch_assoc()){
     if($total_dedaction_row['deduction_type']=='fixed'){

       $total_dedaction=$total_dedaction + $total_dedaction_row['deduction_amt'];
       array_push($k,$total_dedaction_row['deduction_desc']);
       array_push($l,$total_dedaction_row['deduction_amt']);

     }elseif($total_dedaction_row['deduction_type']=='percentage'){
       $result=(($total_dedaction_row['deduction_amt']*$last_scale))/100;
       array_push($k,$total_dedaction_row['deduction_desc']);
       array_push($l,$result);
       $total_dedaction=$total_dedaction+ $result;
       

     }

   }

   
 
   // $total_dedaction=$total_dedaction_row['total_dedaction'];

   if($last_scale!=0){
      $total_netpay=($last_scale+$total_allowance-$total_dedaction);
    }else{
      $total_netpay=0;
    }
 $t_net_p=$t_net_p+$total_netpay;
//  echo
//  "<tr>
//       <td>" . $row['emp_id'] . "</td>
//       <td>" . $row['f_name'] . "</td>
//       <td>" . $row['desig_desc'] . "</td>
//       <td>" . $last_scale  . "</td>
//       <td>" . $total_allowance . "</td>
//       <td>" . $total_dedaction. "</td>
//       <td>" . $total_netpay . "</td>"



      array_push($a,$row['emp_id']);
      array_push($b,$row['f_name']);
      array_push($c,$row['desig_desc']);
      array_push($d,$last_scale);
      array_push($e,$total_allowance);
      array_push($f,$total_dedaction);
      array_push($g,$total_netpay);



}

}





array_push($h,$t_net_p);






// session //
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_addr1 = $_SESSION['org_addr1'];
$org_email = $_SESSION['org_email'];
$org_tel = $_SESSION['org_tel'];  





// Add new pages. By default no pages available.
$pdf->AddPage();
/* Column headings */
// Set font format and font-size
$pdf->Image('habro-logo.png',7,10,8,0,'png');
$pdf->SetFont('Times', 'B', 20);
  
// Framed rectangular area
$pdf->Cell(180, 5,$org_name, 0, 0, 'C');
  
// Set it new line
$pdf->Ln(5);
// Set font format and font-size
$pdf->SetFont('Times', 'B', 15);
  
// Framed rectangular area
$pdf->MultiCell(0, 10, $org_addr1." , E-Mail: " .  $org_email ." ,Tele: " .$org_tel ,10,'C');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(188, 5," Employee Payrole Process Report", 0, 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Times', 'B', 12);
$pdf->MultiCell(0, 10, " As on Date : ".$date,2,'C');
// Set it new line
$pdf->Ln(15);
$header = array('Employee Id', 'Employee Name', 'Designation', 'Basic Salary', 'Total Allowance', 'Total Deduction ', 'Netpay');

	$pdf->SetFont('Arial','',9);
	//$pdf->BasicTable($header);
	
   $pdf->FancyTable($header,$a,$b,$c,$d,$e,$f,$g,$h,$emp_serial,$k,$l);

//$pdf->FancyTable($header,$data);
$pdf->Output();





?>
