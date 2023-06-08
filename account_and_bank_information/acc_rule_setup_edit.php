<?php
require "../auth/auth.php";
require "../database.php";
?>
<?php
//update query
if (isset($_POST['submit'])) {
  $m_inv = $_POST['m_inv'];
  $m_profit_loss_acc = $_POST['m_profit_loss_acc'];
  $allow_multicurrency = $_POST['allow_multicurrency'];
  $m_bill_details = $_POST['m_bill_details'];
  $m_bdtl_for_non_trading_acc = $_POST['m_bdtl_for_non_trading_acc'];
  $active_int_cal = $_POST['active_int_cal'];
  $m_advance_rule = $_POST['m_advance_rule'];
  $m_payroll = $_POST['m_payroll'];
  $a_cost_center = $_POST['a_cost_center'];
  $u_cost_center_for_job = $_POST['u_cost_center_for_job'];
  $u_predefine_cost_c_all_in_transaction = $_POST['u_predefine_cost_c_all_in_transaction'];
  $a_invoicing = $_POST['a_invoicing'];
  $a_dr_cr_note = $_POST['a_dr_cr_note'];
  $a_invoice_for_cr_note = $_POST['a_invoice_for_cr_note'];
  $a_invoice_for_dr_note = $_POST['a_invoice_for_dr_note'];
  $m_buget_and_control = $_POST['m_buget_and_control'];
  $a_rev_journal = $_POST['a_rev_journal'];
  $a_optional_voucher = $_POST['a_optional_voucher'];
  $a_chq_printing = $_POST['a_chq_printing'];
  $check_post_dt_chq = $_POST['check_post_dt_chq'];
  $ss_modified_on = date("Y-m-d H:i:s");

  $idno = $_GET['recortid'];
  $updateQuery = "UPDATE `acc_rule_setup` SET m_inv='$m_inv', m_profit_loss_acc='$m_profit_loss_acc', allow_multicurrency='$allow_multicurrency', m_bill_details='$m_bill_details',m_bdtl_for_non_trading_acc='$m_bdtl_for_non_trading_acc',active_int_cal='$active_int_cal',m_advance_rule='$m_advance_rule',m_payroll='$m_payroll',a_cost_center='$a_cost_center',u_cost_center_for_job='$u_cost_center_for_job',u_predefine_cost_c_all_in_transaction='$u_predefine_cost_c_all_in_transaction',a_invoicing='$a_invoicing',a_dr_cr_note='$a_dr_cr_note',a_invoice_for_cr_note='$a_invoice_for_cr_note',a_invoice_for_dr_note='$a_invoice_for_dr_note',m_buget_and_control='$m_buget_and_control',a_rev_journal='$a_rev_journal',a_optional_voucher='$a_optional_voucher',a_chq_printing='$a_chq_printing',check_post_dt_chq='$check_post_dt_chq', ss_modified_on='$ss_modified_on' WHERE id = '$idno'";
  // echo $updateQuery; exit;
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully";
  }
  header("Location:acc_rule_setup.php");
  
}
//select query start
if (isset($_GET['recortid'])) {
  $idno = $_GET['recortid'];
  $selectQuery = "SELECT * FROM `acc_rule_setup` WHERE id=$idno";
  // echo $selectQuery; exit;
  $selectQueryResult = $conn->query($selectQuery);
  //if($selectQueryResult->num_rows){		
  $row = $selectQueryResult->fetch_array();
  //}
}
?>
<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<style>
  .maingltable {
    border-style: solid;
    border-width: 5px;
  }

  .maingl {
    clear: both;
    height: 50px;
    width: 100%
  }

  .leftgl {
    float: left;
    width: 33%;
  }

  .meddlegl {
    float: left;
    width: 33%
  }

  .rightgl {
    float: right;
    width: 33%
  }

  @media screen and (max-width: 800px) {

    .leftgl,
    .meddlegl,
    .rightgl {
      width: 100%;
      text-align: center;
    }
  }

  @media screen and (max-width: 500px) {

    .leftgl,
    .meddlegl,
    .rightgl {
      width: 100%;
      text-align: center;

    }
  }
</style>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Menu Edit</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <!-- top start  -->
      <div class="maingltable">
        <div class="maingl">
          <div class="leftgl">
            <p>Logo. Organigation Name</p>
            <p>System Name</p>
          </div>
          <div class="meddlegl">

            <h2>GL Account</h2>
          </div>
          <div class="rightgl">
            <p>Process Month And Year:..-07-2019</p>
            <p>User:xxxxxxxxxx</p>
          </div>

        </div>
        <hr>
        <div style="padding:20px;">
          <!-- form start  -->
    <?php if (isset($message)) echo $message; ?>

          <form action="" method="post">
          <input type="hidden" name="recid" value="<?php echo $row['id']; ?>"/>
            <!-- acc rule setup edit start-->
             <!-- Maintain Inventory  -->
             <div class="form-group row">
              <label class="col-sm-4 col-form-label">Maintain Inventory</label>
              <div class="col-sm-6">
               <select required name="m_inv" id="" class="form-control">
                  <option value="Y" <?php if ($row['m_inv'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['m_inv'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- aintain Profile Loss A/C  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">aintain Profile Loss A/C</label>
              <div class="col-sm-6">
             <select required name="m_profit_loss_acc" id="" class="form-control">
                  <option value="Y" <?php if ($row['m_profit_loss_acc'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['m_profit_loss_acc'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Allow Multicurrency -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Allow Multicurrency</label>
              <div class="col-sm-6">
               <select required name="allow_multicurrency" class="form-control">
                  <option value="Y" <?php if ($row['allow_multicurrency'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['allow_multicurrency'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div><!-- Maintain Bill detail -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Maintain Bill detail</label>
              <div class="col-sm-6">
               <select required name="m_bill_details" class="form-control">
                  <option value="Y" <?php if ($row['m_bill_details'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['m_bill_details'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Maintain Bill Detail for non-trading a/c -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Maintain Bill Detail for non-trading a/c</label>
              <div class="col-sm-6">
               <select required name="m_bdtl_for_non_trading_acc" class="form-control">
                  <option value="Y" <?php if ($row['m_bdtl_for_non_trading_acc'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['m_bdtl_for_non_trading_acc'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Activate Interest Calculation -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Activate Interest Calculation</label>
              <div class="col-sm-6">
               <select required name="active_int_cal" class="form-control">
                  <option value="Y" <?php if ($row['active_int_cal'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['active_int_cal'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Maintain Advance Rules -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Maintain Advance Rules</label>
              <div class="col-sm-6">
               <select required name="m_advance_rule" class="form-control">
                  <option value="Y" <?php if ($row['m_advance_rule'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['m_advance_rule'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Maintain Payroll -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Maintain Payroll</label>
              <div class="col-sm-6">
               <select required name="m_payroll" class="form-control">
                  <option value="Y" <?php if ($row['m_payroll'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['m_payroll'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Allow cost Center  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Allow cost Center </label>
              <div class="col-sm-6">
               <select required name="a_cost_center" class="form-control">
                  <option value="Y" <?php if ($row['a_cost_center'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_cost_center'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Use cost center for job costing  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use cost center for job costing </label>
              <div class="col-sm-6">
               <select required name="u_cost_center_for_job" class="form-control">
                  <option value="Y" <?php if ($row['u_cost_center_for_job'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['u_cost_center_for_job'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Use predefine cost center allocation in Transaction -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use predefine cost center allocation in Transaction</label>
              <div class="col-sm-6">
               <select required name="u_predefine_cost_c_all_in_transaction" class="form-control">
                  <option value="Y" <?php if ($row['u_predefine_cost_c_all_in_transaction'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['u_predefine_cost_c_all_in_transaction'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Allow Invoicing -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Allow Invoicing</label>
              <div class="col-sm-6">
               <select required name="a_invoicing" class="form-control">
                  <option value="Y" <?php if ($row['a_invoicing'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_invoicing'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Use debit/credit Note  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use debit/credit Note </label>
              <div class="col-sm-6">
               <select required name="a_dr_cr_note" class="form-control">
                  <option value="Y" <?php if ($row['a_dr_cr_note'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_dr_cr_note'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!--Use invoice mode for Credit Note -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use invoice mode for Credit Note</label>
              <div class="col-sm-6">
               <select required name="a_invoice_for_cr_note" class="form-control">
                  <option value="Y" <?php if ($row['a_invoice_for_cr_note'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_invoice_for_cr_note'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Use invoice mode for Debit Note -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use invoice mode for Debit Note</label>
              <div class="col-sm-6">
               <select required name="a_invoice_for_dr_note" class="form-control">
                  <option value="Y" <?php if ($row['a_invoice_for_dr_note'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_invoice_for_dr_note'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Maintain Budget and control -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Maintain Budget and control</label>
              <div class="col-sm-6">
               <select required name="m_buget_and_control" class="form-control">
                  <option value="Y" <?php if ($row['m_buget_and_control'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['m_buget_and_control'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Use Reversing Journal  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use Reversing Journal and Optional Voucher</label>
              <div class="col-sm-6">
             <select required name="a_rev_journal" class="form-control">
                  <option value="Y" <?php if ($row['a_rev_journal'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_rev_journal'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- use Optional Voucher  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use Reversing Journal and Optional Voucher</label>
              <div class="col-sm-6">
             <select required name="a_optional_voucher" class="form-control">
                  <option value="Y" <?php if ($row['a_optional_voucher'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_optional_voucher'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Enable Cheque Printion  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Enable Cheque Printion</label>
              <div class="col-sm-6">
             <select required name="a_chq_printing" class="form-control">
                  <option value="Y" <?php if ($row['a_chq_printing'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['a_chq_printing'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- Check Post Dated Cheque  -->
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Check Post Dated Cheque</label>
              <div class="col-sm-6">
             <select required name="check_post_dt_chq" class="form-control">
                  <option value="Y" <?php if ($row['check_post_dt_chq'] == "Y") {echo 'selected="selected"';} ?>>Yes</option>
                  <option value="N" <?php if ($row['check_post_dt_chq'] == "N") {echo 'selected="selected"';} ?>>No</option>
                </select>
              </div>
            </div>
            <!-- acc rule setup edit end-->
            <!-- submit  -->
            <div class="form-group row">
              <div class="col-sm-10">
                <!-- <button type="submit" class="btn btn-primary" name="subBtn">Submit</button> -->
          <input name="submit" type="submit" value="Update" class=" btn btn-primary form-control text-center" />

              </div>
            </div>
          </form>
        </div>
        <!-- form close  -->
      </div>
    </div>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>


<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>

<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#302000").addClass('active');
    $("#300000").addClass('active');
    $("#300000").addClass('is-expanded');
  });
</script>

</body>

</html>