<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
$user_id = $_SESSION['link_id'];
if (empty($user_id)) {
  $sql2 = "SELECT  user_info.id, user_info.office_code, user_info.username, office_info.office_code, office_info.office_name FROM  user_info, office_info where office_info.office_code=user_info.office_code";
} else {
  $sql2 =   "SELECT  user_info.id, user_info.office_code, user_info.username, office_info.office_code, office_info.office_name FROM  user_info, office_info where office_info.office_code=user_info.office_code";
}
require "../source/top.php";
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();



$pid = 1310000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
      <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Estimated Project Value Report </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
              <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            </ul>
       </div>

       <?php if ($seprt_cs_info == 'Y') { ?>


          <!-- ===== button define ====== -->
          <div>
            <button id="SummRepBtn" class="btn btn-primary"><i class="fa fa-plus"></i>Total Summary Report</button>
            <button id="ProjRepBtn" class="btn btn-primary"><i class="fa fa-eye"></i>Individual Proj. Report </button>
            <button id="detailRepBtn" class="btn btn-primary"><i class="fa fa-eye"></i>Group Item for Project </button>
          </div>
           <!-- ====== button Define closed ====== -->
    <div class="row">
          <div class="col-md-12">
                <div id="SummRep" class="collapse">
                            <?php
                              $org_logo = $_SESSION['org_logo'];
                              $org_name = $_SESSION['org_name'];
                            ?>
                          <div>
                                <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
                                <h4 style="text-align:center"><?php echo "Total Project Value and Estemated Cost"; ?></h2>
                          </div>
                          <table border="1" style="width: 100%;margin-top:10px">
                              <thead>
                                   <tr style="background-color:powderblue; text-align: center";>
                                      <!-- <th style="width:2%">Sl.NO.</th> -->
                                      <th >Sl.NO.</th>
                                      <th>Project Name</th>
                                      <th>Project Value</th>
                                      <th>Estimated Cost</th>
                                      
                                     </tr>
                              </thead>
                               <tbody>
                                      <?php
                                      $d = 0;
                                      $no = 1;
                                      $group_id = 0;
                                    
                                      $tot_proj_value =0.00;
                                      $tot_Estm_cost=0.00;

                                      $sql ="SELECT project_detail.`office_code`, project_detail.item_no, sum(project_detail.tot_amt_loc) as proj_value, sum(project_detail.vari_estm_cost) as estimate_value, item.item_name, office_info.office_name FROM `project_detail`,item, office_info where project_detail.item_no=item.id and project_detail.office_code=office_info.office_code group by  office_info.office_code";
                        
                
                                      $query = $conn->query($sql);
                                      while ($rows = $query->fetch_assoc()) {
                                      ?>
                                      <tr>
                                            <td style="text-align: right"><?php  echo $no++; ?></td>  

                                          <td style="text-align: center"><?php  echo $rows['office_name']; ?></td>  
                                          <td style="text-align: right"> <?php echo $rows['proj_value']; $tot_proj_value = $tot_proj_value + $rows['proj_value'];  ?></td>  
                                            <td style="text-align: right"><?php  echo $rows['estimate_value']; 
                                                                                  $tot_Estm_cost = $tot_Estm_cost + $rows['estimate_value']; ?></td>  
                                                                                          
                                      </tr>
                                      
                                      <?php } ?>
                                          <tfoot>
                                          <tr style="background-color:powderblue";>
                                                  <th style="text-align:right" colspan="2"> Total Amount in TK.</th>
                                                  <th style="text-align:right" colspan="1"><?php echo $tot_proj_value; ?></th>
                                                  <th style="text-align:right" colspan="1"><?php echo $tot_Estm_cost; ?></th>
                                                  
                                              </tr>
                                          </tfoot>
                                   </tbody>
                           </table>
                       </div>
                 </div>
             
        <div class="col-md-12">
           <div class="tile" id="ProjRep">
              <div class="tile-body">
               <form method="POST">
                   <table id="submit">
                          <tr>
                                 <td>Project Name : <select class="form-control grand" name="office_code">
                                     <option value="">--- Select Project ---</option>
                                     <?php
                                         $selectQuery = "SELECT * FROM `office_info` where  office_type='2' ORDER by office_code";
                                         $selectQueryResult =  $conn->query($selectQuery);
                                        if ($selectQueryResult->num_rows) {
                                            while ($drrow = $selectQueryResult->fetch_assoc()) {
                                           echo '<option value="' . $drrow['office_code'] . '">'  . $drrow['office_name'] . '</option>';
                                }
                               }
                            ?>
                        </select></td>
                           <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                      </tr>
                      </form>
                   </table>
                   <?php
                    $org_logo = $_SESSION['org_logo'];
                    $org_name = $_SESSION['org_name'];
                    if (isset($_POST['submit'])) {
                       $office_code = $conn->escape_string($_POST['office_code']);
                    //   $sql_off= "SELECT office_name FROM office_info where office_code='$office_code'";
                    //   $row_off =  $conn->query($sql_off);
                    }else  {
                      $office_code = $_SESSION['office_code'];
                    }
                    
                    ?>
                     <div>
                        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
                        
                         <h3 style="text-align:center">Project Name : <?php  echo $office_code; ?></h3>
                     </div>
  
                    <table border="1" style="width: 100%;margin-top:10px">
                          <thead>
                              <tr style="background-color:powderblue; text-align: center";>
                                      <th >Sl.NO.</th>
                                      <th>Group Item Code</th>
                                      <th>Item Name</th>
                                      <th>Item QTY</th>
                                      <th>Unit Price</th>
                                      <th>Project Value</th>
                                      <th>Estimated Cost</th>
                               </tr>
                           </thead>
                          <tbody>
                              <?php
                              $d = 0;
                              $no = 1;
                              $group_id = 0;
                            
                              $tot_proj_value =0.00;
                              $tot_Estm_cost=0.00;
                              $item_group_value=0.00;
                              $item_group_cost=0.00;
                        
                              if (isset($_POST['submit'])) {
                                $office_code = $conn->escape_string($_POST['office_code']);

                                $sql="SELECT project_detail.`office_code`, project_detail.item_no,project_detail.item_unit,project_detail.item_qty,project_detail.unit_price, project_detail.tot_amt_loc, project_detail.vari_estm_cost, item.item_name, item.parent_id, office_info.office_name, code_master.description FROM `project_detail`,item, office_info, code_master where project_detail.item_no=item.id and project_detail.office_code=office_info.office_code and project_detail.office_code='$office_code'  and hardcode='UCODE' and code_master.softcode=project_detail.item_unit order by   office_info.office_code,item.parent_id";

                              } else {
                                        
                                        $office_code = $_SESSION['office_code'];
                                        
                                        $sql="SELECT project_detail.`office_code`, project_detail.item_no,project_detail.item_unit,project_detail.item_qty,project_detail.unit_price, project_detail.tot_amt_loc, project_detail.vari_estm_cost, item.item_name, item.parent_id, office_info.office_name, code_master.description FROM `project_detail`,item, office_info, code_master where project_detail.item_no=item.id and project_detail.office_code=office_info.office_code and project_detail.office_code='$office_code'  and hardcode='UCODE' and code_master.softcode=project_detail.item_unit order by   office_info.office_code,item.parent_id";       
                            } 
                                $query = $conn->query($sql);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                                <tr>
                                      <td style="text-align: right"><?php if ($rows['parent_id'] != $group_id) {
                                                                          echo $no++; 
                                                                        } else {
                                                                            echo "";
                                                                        }?></td>  
                                      
                                    <td style="text-align: center"><?php if ($rows['parent_id'] != $group_id) {
                                                                            echo $rows['parent_id']; 
                                                                        } else {
                                                                            echo "";
                                                                        }?></td>
                                      
                                    <td style="text-align: left"><?php  echo $rows['item_name'];  ?></td>                                         
                                                                                    
                                    <td style=" background-color:powderblue; text-align: right"><?php echo $rows['item_qty'];echo "  "; echo $rows['description']; ?></td>
                                    <td style=" background-color:powderblue; text-align: right"><?php echo $rows['unit_price']; ?></td>
                                    <td style="text-align: right"> <?php echo $rows['tot_amt_loc']; $tot_proj_value = $tot_proj_value + $rows['tot_amt_loc'];  ?></td>  
                                                                    
                                    
                                      <td style="text-align: right"><?php  echo $rows['vari_estm_cost']; 
                                                                            $tot_Estm_cost = $tot_Estm_cost + $rows['vari_estm_cost'];
                                                                            $group_id=$rows['parent_id']; ?></td>  
                                                                                    
                                </tr>
                                
                                <?php } ?>
                               <tfoot>
                                    <tr style="background-color:powderblue";>
                                        <th style="text-align:right" colspan="5"> Total Amount in TK.</th>
                                        <th style="text-align:right" colspan="1"><?php echo $tot_proj_value; ?></th>
                                        <th style="text-align:right" colspan="1"><?php echo $tot_Estm_cost; ?></th>
                                   </tr>
                              </tfoot>
                            </tbody>
                          </table>
                         </form>
                       </div>
                   </div>
                </div>
     <!--  Detail Rerpot  -->
        
        <div class="col-md-12">
           <div class="tile" id="detailRep">
              <div class="tile-body">
                <form method="POST">      
                    <table id="submit">
                            <tr>
                                 <td>Project Name : <select class="form-control grand" name="office_code">
                                      <option value="">--- Select Project ---</option>
                                      <?php
                                      $selectQuery = "SELECT * FROM `office_info` where  office_type='2' ORDER by office_code";
                                      $selectQueryResult =  $conn->query($selectQuery);
                                      if ($selectQueryResult->num_rows) {
                                          while ($drrow = $selectQueryResult->fetch_assoc()) {
                                              echo '<option value="' . $drrow['office_code'] . '">'  . $drrow['office_name'] . '</option>';
                                          }
                                      }
                                      ?>
                                      </select></td>

                                      <td>Group Item Name : <select class="form-control grand" name="parent_id">
                                      <option value="">--- Select Item Group ---</option>
                                      <?php
                                      $selectQuery = "SELECT * FROM item where  item_level ='2' ORDER by parent_id";
                                      $selectQueryResult =  $conn->query($selectQuery);
                                      if ($selectQueryResult->num_rows) {
                                          while ($drrow = $selectQueryResult->fetch_assoc()) {
                                              echo '<option value="' . $drrow['parent_id'] . '">'  . $drrow['item_name'] . '</option>';
                                          }
                                      }
                                      ?>
                                      </select></td>
                                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                             </tr>
                       </form>
                  </table>
                  <?php
                  $org_logo = $_SESSION['org_logo'];
                  $org_name = $_SESSION['org_name'];
                  if (isset($_POST['submit'])) {
                    $office_code = $conn->escape_string($_POST['office_code']);
                 }else  {
                   $office_code = $_SESSION['office_code'];
                 }
                 
                  
                   ?>
                       <div>
                          <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
                          <h3 style="text-align:center">Project Name : <?php   if (empty($office_code)) {
                                                            echo "All Project";
                                                        } else {
                                                            echo $office_code;
                                                        } ?></h3>
                      </div>
                      <table border="1" style="width: 100%;margin-top:10px">
                          <thead>
                          <tr style="background-color:powderblue; text-align: center";>
                                  <!-- <th style="width:2%">Sl.NO.</th> -->
                                  <th >Sl.NO.</th>
                                  <th>Project Name</th>
                                  <th>Group Item Code</th>
                                  <th>Item Name</th>
                                  <th>Item QTY</th>
                                  <th>Unit Price</th>
                                  <th>Project Value</th>
                                  <th>Estimated Cost</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              $d = 0;
                              $no = 1;
                              $group_id = 0;
                            
                              $tot_proj_value =0.00;
                              $tot_Estm_cost=0.00;
                              $item_group_value=0.00;
                              $item_group_cost=0.00;
                          
                              if (isset($_POST['submit'])) {
                                $office_code = $conn->escape_string($_POST['office_code']);
                                $parent_id = $conn->escape_string($_POST['parent_id']);

                                $sql="SELECT project_detail.`office_code`, project_detail.item_no,project_detail.item_unit,project_detail.item_qty,project_detail.unit_price, project_detail.tot_amt_loc, project_detail.vari_estm_cost, item.item_name, item.parent_id, office_info.office_name, code_master.description FROM `project_detail`,item, office_info, code_master where project_detail.item_no=item.id and project_detail.office_code=office_info.office_code and project_detail.office_code='$office_code' and item.parent_id='$parent_id' and hardcode='UCODE' and code_master.softcode=project_detail.item_unit order by   office_info.office_code,item.parent_id";

                              
                              } else {  
                                  
                                  $sql="SELECT project_detail.`office_code`, project_detail.item_no,project_detail.item_unit,project_detail.item_qty,project_detail.unit_price, project_detail.tot_amt_loc, project_detail.vari_estm_cost, item.item_name, item.parent_id, office_info.office_name, code_master.description FROM `project_detail`,item, office_info, code_master where project_detail.item_no=item.id and project_detail.office_code=office_info.office_code and  hardcode='UCODE' and code_master.softcode=project_detail.item_unit order by   office_info.office_code,item.parent_id ";
                              }
                              
                              $query = $conn->query($sql);
                              while ($rows = $query->fetch_assoc()) {
                              ?>
                              <tr>
                                    <td style="text-align: right"><?php if ($rows['parent_id'] != $group_id) {
                                                                        echo $no++; 
                                                                      } else {
                                                                          echo "";
                                                                      }?></td>  

                                  <td style="text-align: center"><?php if ($rows['parent_id'] != $group_id) {
                                                                          echo $rows['office_name']; 
                                                                      } else {
                                                                          echo "";
                                                                      }?></td>  
                                  <td style="text-align: center"><?php if ($rows['parent_id'] != $group_id) {
                                                                          echo $rows['parent_id']; 
                                                                      } else {
                                                                          echo "";
                                                                      }?></td>
                                    
                                  <td style="text-align: left"><?php  echo $rows['item_name'];  ?></td>                                         
                                                                                  
                                  <td style=" background-color:powderblue; text-align: right"><?php echo $rows['item_qty'];echo "  "; echo $rows['description']; ?></td>
                                  <td style=" background-color:powderblue; text-align: right"><?php echo $rows['unit_price']; ?></td>
                                  <td style="text-align: right"> <?php echo $rows['tot_amt_loc']; $tot_proj_value = $tot_proj_value + $rows['tot_amt_loc'];  ?></td>  
                                                                  
                                  
                                    <td style="text-align: right"><?php  echo $rows['vari_estm_cost']; 
                                                                          $tot_Estm_cost = $tot_Estm_cost + $rows['vari_estm_cost'];
                                                                          $group_id=$rows['parent_id']; ?></td>  
                                                                                  
                              </tr>
                              
                              <?php } ?>
                          <tfoot>
                              <tr style="background-color:powderblue";>
                                  <th style="text-align:right" colspan="6"> Total Amount in TK.</th>
                                  <th style="text-align:right" colspan="1"><?php echo $tot_proj_value; ?></th>
                                  <th style="text-align:right" colspan="1"><?php echo $tot_Estm_cost; ?></th>
                              </tr>
                          </tfoot>
                        </tbody>
                      </table>
                     </form>
                  </div>
               </div> 
            </div>
        </div>
        <?php
        } else {
          echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
        } ?>

      </div>
      </div>
   </div>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
  $('#memberTable').DataTable();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#1310000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded')
  });

  $('#ProjRep').hide();
  $('#detailRep').hide();
  $('#SummRep').hide();

  // SummRepBtn
  $('#SummRepBtn').on('click', function() {
    $('#SummRep').show();
    $('#ProjRep').hide();
    $('#detailRep').hide();
    $('#SummRepBtn').attr('class', 'btn btn-danger');
    $('#ProjRepBtn').attr('class', 'btn btn-primary');
    $('#detailRepBtn').attr('class', 'btn btn-primary');


  });
  // memberistBtn
  $('#ProjRepBtn').on('click', function() {
    $('#ProjRep').show();
    $('#SummRep').hide();
    $('#detailRep').hide();
    $('#ProjRepBtn').attr('class', 'btn btn-danger');
    $('#SummRepBtn').attr('class', 'btn btn-primary');
    $('#detailRepBtn').attr('class', 'btn btn-primary');
  });

  $('#detailRepBtn').on('click', function() {
    $('#detailRep').show();
    $('#SummRep').hide();
    $('#ProjRep').hide();
    $('#detailRepBtn').attr('class', 'btn btn-danger');
    $('#ProjRepBtn').attr('class', 'btn btn-primary');
    $('#SummRepBtn').attr('class', 'btn btn-primary');
  });
</script>
<?php
$conn->close();

?>
</body>

</html>