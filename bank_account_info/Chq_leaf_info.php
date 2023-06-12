<?php
require "../auth/auth.php";
$cust_id = $_SESSION['link_id'];
require "../database.php";
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";

?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Chaque Leaf Info of Chaque Book</h1>
        </div>
    </div>

          <table id="submit">
            <form method="POST">
                <tr>
                    <td>Account No.: <select class="form-control grand" name="bank_acc_no">
                            <option value="">--- Select Account No.---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `bank_acc_info`  ORDER by bank_acc_no";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['bank_acc_no'] . '">'  . $row['acc_name'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td> As on date: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> From: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
   
    ?>
    <!-- !search option -->
    <!-- report header start -->
    <?php
    $org_logo = $_SESSION['org_logo'];
    $org_name = $_SESSION['org_name'];
    ?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
        <h3 style="text-align:center">Account Name : <?php
                                                        if (empty($bank_acc_no)) {
                                                            echo "All Account";
                                                        } else {
                                                            echo $row['acc_name'];
                                                        } ?></h3>
    </div>
    <!-- report header end -->
    <!-- search option -->
    <div class="table-responsive-lg">
        <table border="1" style="width: 100%;margin-top:10px">
            <thead>
            <tr style="background-color:powderblue; text-align: center";>
                    <!-- <th style="width:2%">Sl.NO.</th> -->
                    <th >Sl.NO.</th>
                    <th>Office Code</th>
                    <th>Bank Account No.</th>
                    <th>Account Name</th>
                    <th>Bank Name</th>
                    <th>Branch Name</th>
                    <th>Chaque issue Date</th>
                    <th>Chaque No </th>
                    <th>Chaque Status</th>
                    <th>Status Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;
                $acc_no="";
                $id=0;
                
            
                 if (isset($_POST['submit'])) {
                   $startdate = $_POST['startdate'];
                   $enddate = $conn->escape_string($_POST['enddate']);
                   $bank_acc_no = $conn->escape_string($_POST['bank_acc_no']);

                    
                    $sql = "SELECT bank_chq_leaf_info.chq_book_id as id, bank_chq_leaf_info.office_code, bank_chq_leaf_info.account_no as bank_acc_no, bank_acc_info.acc_name, bank_acc_info.bank_name,bank_acc_info.branch_name,  bank_chq_leaf_info.issue_date,bank_chq_leaf_info.chq_prefix, bank_chq_leaf_info.chq_leaf_no,bank_chq_leaf_info.leaf_status,bank_chq_leaf_info.status_date  from bank_chq_leaf_info ,bank_acc_info where bank_acc_info.bank_acc_no=bank_chq_leaf_info.account_no and bank_chq_leaf_info.account_no='$bank_acc_no' and (bank_chq_leaf_info.issue_date BETWEEN '$startdate' AND '$enddate') order by  bank_chq_leaf_info.chq_leaf_no";

                 } else {   
                      
                    $sql = "SELECT bank_chq_leaf_info.chq_book_id as id, bank_chq_leaf_info.office_code, bank_chq_leaf_info.account_no as bank_acc_no, bank_acc_info.acc_name, bank_acc_info.bank_name,bank_acc_info.branch_name,  bank_chq_leaf_info.issue_date,bank_chq_leaf_info.chq_prefix, bank_chq_leaf_info.chq_leaf_no,bank_chq_leaf_info.leaf_status,bank_chq_leaf_info.status_date  from bank_chq_leaf_info ,bank_acc_info where bank_chq_leaf_info.account_no=bank_acc_info.bank_acc_no";

                 }

                
                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                ?>
                 <tr>
                
                 <td style="text-align: right"><?php if ($rows['id'] > $id) {
                                                            echo $no++; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                      <td style="text-align: center"><?php if ($rows['id'] > $id) {
                                                            echo $rows['office_code']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                     <td style="text-align: center"><?php if ($rows['id'] > $id) {
                                                            echo $rows['bank_acc_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                                                        
                     <td style="text-align: center"><?php if ($rows['id'] > $id) {
                                                            echo $rows['acc_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                     <td style="text-align: center"><?php if ($rows['id'] > $id) {
                                                            echo $rows['bank_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                         <td style="text-align: center"><?php if ($rows['id'] > $id) {
                                                            echo $rows['branch_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                        <td style="text-align: center"><?php if ($rows['id'] > $id) {
                                                            echo $rows['issue_date']; 
                                                            $id=$rows['id'];
                                                        } else {
                                                            echo "";
                                                        }?></td>                                  
          
                      <td style="background-color:powderblue; text-align: left"><?php echo $rows['chq_leaf_no'];?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php if ($rows['leaf_status'] == '0') {
                                                            echo "Un-used leaf"; 
                                                        } else {
                                                           echo "leaf used ";
                                                        }?></td>
                                    
                    
                    
                    
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['status_date']; ?></td> 
                    
                     
                   
                     
                 </tr>
                 
                <?php } ?>
            <tfoot>
            <tr style="background-color:powderblue";>
                      
                </tr>
            </tfoot>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
    <!-- table -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>

<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#803000").addClass('active');
        $("#800000").addClass('active');
        $("#800000").addClass('is-expanded');
    });
</script>
</body>

</html>