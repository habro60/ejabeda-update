<?php
require "../auth/auth.php";

if (isset($_GET['sdate'])) {

    $timestamp = time();
    $filename = 'bill_due_report-' . $timestamp . '.doc';
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    $startdate = $_GET['sdate'];
    $enddate = $_GET['edate'];
    $gl_acc_code = $_GET['gl_acc_code'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $org_addr1= $_SESSION["org_addr1"];
    $org_email= $_SESSION["org_email"];
    $org_website=$_SESSION["org_website"];
    $org_tel=$_SESSION["org_tel"];
    $q = $_SESSION['org_rep_footer1'];
    $b = $_SESSION['org_rep_footer2'];
    
    $org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
    // require_once 'pdf.php';
    include('../database.php');
    $output = '';
    $output .= "<center><strong> $org</strong></center>";
    $output .= "<center><strong> $org_addr1</strong></center>";
    $output .= "<center><strong>Email:$org_email  Telephon: $org_tel</strong></center>";   
    $output .= '<h3 style="text-align:center">Owner Services Bill Due Report</h3>';
    $output .= "<center><strong>From Date:$startdate To : $enddate</strong></center>";
    $output .= '<div style="float: right;width: 100%;height: auto;border-style: solid">
    <table class=prtint-break-after :always  style="width: 100%">
        <thead>
            <tr style="text-align:center;background-color:lightgray">
            <th >Sl.NO.</th>
            <th>Owner Name</th>
            <th>Service Bill Date</th>
            <th>Bill for Month</th>
            <th>Voucher No</th>
            <th>Flat Number</th>
            <th>Service Name</th>
            <th>Bill amount</th>
            </tr>
            
        </thead>
        <tbody>';

                $d = 0;
                $no = 0;
                $own_id = 0;
                $tot_cr_amt =0.00;
                $tot_due=0.00;
                $owner_id = $_SESSION['link_id'];
            
                if (empty($owner_id)) {
                                
                    // $startdate = $_POST['startdate'];
                    // $enddate = $conn->escape_string($_POST['enddate']);
                    //  $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);
                    if (empty($gl_acc_code)) { 

                        $sql="SELECT apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_charge_code,apart_owner_bill_detail.bill_charge_name,date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month,apart_owner_bill_detail.bill_amount, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.bill_paid_flag, tran_details.tran_date, tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.batch_no, apart_owner_info.owner_id,apart_owner_info.owner_name from apart_owner_bill_detail, tran_details, apart_owner_info where tran_details.vaucher_type='DR' and tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_info.owner_id=apart_owner_bill_detail.owner_id and tran_details.tran_date=apart_owner_bill_detail.bill_process_date and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag='0' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";


                    }else {

                        $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.dr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount,apart_owner_bill_detail.flat_no, apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_gl_code='$gl_acc_code'and  tran_details.vaucher_type='DR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_process_date and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag=0  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";

                    }

                    
                    } 
                
                    if (!empty($owner_id))  {
                   
                    // $startdate = $_POST['startdate'];
                    // $enddate = $conn->escape_string($_POST['enddate']);

                        $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.dr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount, apart_owner_bill_detail.flat_no,apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_id='$owner_id'and  tran_details.vaucher_type='DR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_process_date and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag=0 AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";
                        }

                $query = $conn->query($sql);
                while ($row = $query->fetch_assoc()) {
                   
                    if ($row['owner_id'] != $own_id) {
                        $no++;
                        $output .=  "<tr><td style='color:gray; font-weight:bold'>" . $no . "</td>
                        <td style='text-align:left'>" . $row['owner_name'] . "</td>
                        <td style='text-align:left'>" . $row['tran_date'] . "</td>
                        <td style='text-align:left'>" . $row['month'] . "</td>
                        <td style='text-align:left'>" . $row['batch_no'] . "</td>
                       
                        <td style='text-align:left'>" . $row['flat_no'] . "</td>
                        <td style='text-align:left'>" . $row['bill_charge_name'] . "</td>
                        <td style='text-align:right'>" . $row['bill_amount'] . "</td>
                            </tr>";
                            $own_id=$row['owner_id'];
                            $tot_due= $tot_due + $row['bill_amount'];
                    } else {
                        $output .=  "<tr><td styltext-indent:20px;color:blue; font-weight:bold'>"."". "</td>
                        <td style='text-align:left'>" . "" . "</td>
                        <td style='text-align:left'>".""."</td>
                        <td style='text-align:left'>" . $row['month'] . "</td>
                        <td style='text-align:left'>" . $row['batch_no'] . "</td>
                        
                        <td style='text-align:left'>" . $row['flat_no'] . "</td>
                        <td style='text-align:left'>" . $row['bill_charge_name'] . "</td>
                        <td style='text-align:right'>" . $row['bill_amount'] . "</td>
                            </tr>";
                            $tot_due= $tot_due + $row['bill_amount'];

                        }
                        
                       
                    }
                                       
                    $output .= '<tr>
                    <th colspan="7" style="text-align: right"> Total</th>
                    <th style="text-align: right"><strong>' . $tot_due. '</strong></th>
                </tr>';
                    $output .= '</tbody></table></div></div>';
                    $output .= '<br>';
                    $output .= '<br>';
                    $output .= '<br>';
                    $output .= '<br>';
                    $output .= '<br>';
                    $output .= '<br>';
                    $output .= "<div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong>$q</strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong>$b</strong></div></div>";
            
                echo $output;
                
                }
                