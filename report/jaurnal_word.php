 <?php
    require "../auth/auth.php";
    if (isset($_GET["date"])) {
        $timestamp = time();
        $filename = 'jaurnal_word-' . $timestamp . '.doc';
        header("Content-type: application/vnd.ms-word");
        // header("Content-Disposition: attachment;Filename=" . rand() . ".doc");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $org_name = $_SESSION['org_name'];
        $org_logo = $_SESSION['org_logo'];
        $org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
        // $org ='<div><h2 style="text-align:center"><img src="../upload/$org_logo" alt="logo" style="width:40px;height:40px;">$org_name</h2></div>';
        $date = $_GET["date"];
        $a = "<h4 style='text-align:center'>$date</h4>";
        require_once 'pdf.php';
        include('../database.php');
        $output = '';
        $output .= $org;
        $output .= '<h3 style="text-align:center">Journal Statement</h3>';
        $output .= $a;
        $output .= '
  <table width="100%" border="1" cellspacing="0">
  <tr class="active">
      <th>Date</th>
      <th>TR type </th>
      <th>TR No </th>
      <th>Voucher No. </th>
      <th>Account Number </th>
      <th>Account Head </th>
      <th>Particular </th>
      <th>Debit </th>
      <th>Credit</th>
  </tr>';
        $sql = "SELECT tran_details.batch_no,tran_details.tran_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date $date) ORDER BY tran_details.batch_no";
        $query = $conn->query($sql);
        while ($rows = $query->fetch_assoc()) {
            $output .= "<tr>
     <td style='width:100px'>" . $rows['tran_date'] . "</td>
     <td>" . $rows['tran_mode'] . "</td>
     <td>" . $rows['tran_no'] . "</td>
     <td>" . $rows['batch_no'] . "</td> 
     <td>" . $rows['gl_acc_code'] . "</td>
     <td>" . $rows['acc_head'] . "</td>
     <td>" . $rows['description'] . "</td>
     <td style='width:100px'>" . $rows['dr_amt_loc'] . "</td>
     <td style='width:100px'>" . $rows['cr_amt_loc'] . "</td>
  </tr>";
        }
    }
    echo $output;
    ?>