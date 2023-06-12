<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 1011000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/sidebar.php';
require '../source/header.php';

$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Sales Return</h1>
    </div>
  </div>
  <table>
    <form method="POST">
      <tr>
        <td>
          <input type="number" name="order_no" id="" class="form-control" placeholder="Input Sales Voucher No" required>

        </td>
        <td><input type="submit" name="submit" value="submit" class="form-control btn-info"></td>
      </tr>
    </form>
  </table>
  <?php
  if (isset($_POST['submit'])) {
    $order_no = $_POST['order_no'];
  ?>
    <table class="table table-hover table-bordered table-sm">
      <thead>
        <tr style="background-color :lightblue">
          <th>id</th>
          <th>Voucher No </th>
          <th>Item Name</th>
          <th>Trans. date</th>
          <th>Quanitity</th>
          <th>Unit Price</th>
          <th>Total Price</th>
          <th>Status</th>
          <th>Return</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT invoice_detail.id, invoice_detail.item_no, invoice_detail.order_date,invoice_detail.order_no, invoice_detail.item_unit, invoice_detail.item_qty AS item_qty,invoice_detail.unit_price_loc as unit_price_loc, invoice_detail.total_price_loc as total_price_loc, invoice_detail.item_status, item.item_name as item_name FROM invoice_detail JOIN item WHERE invoice_detail.item_no=item.id AND invoice_detail.order_type='SV' AND invoice_detail.order_no='$order_no'";
        $query = $conn->query($sql);
        while ($row = $query->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $row['id'] . '</td>';
          echo '<td>' . $row['order_no'] . '</td>';
          echo '<td>' . $row['item_name'] . '</td>';
          echo '<td>' . $row['order_date'] . '</td>';
          echo '<td>' . $row['item_qty'] . '</td>';
          echo '<td>' . $row['unit_price_loc'] . '</td>';
          echo '<td>' . $row['total_price_loc'] . '</td>';
          // status
          if ($row['item_status'] == '2') {
            echo '<td><button class="btn btn-danger btn-sm" onclick="return false">Return Goods</button></td>';
          } elseif ($row['item_status'] == '3') {
            echo '<td><button class="btn btn-success btn-sm" onclick="return false"> Payment</button></td>';
          } else {
            echo '<td><button class="btn btn-info btn-sm" onclick="return false">Not Return Goods</button></td>';
          }
          // return 
          if ($row['item_status'] == '1') {
            echo '<td><a onclick="returnRow(' . $row["id"] . ',' . $row["order_no"] . ',' . $row["total_price_loc"] . ' )" class="btn btn-info fas fa-send-back">Return</a></td>';
          } elseif ($row['item_status'] == '3') {
            echo '<td><a class="btn btn-success fas fa-send-back" onclick="return false">Return</a></td>';
          } else {
            echo '<td><a class="btn btn-danger fas fa-send-back" onclick="return false">Return</a></td>';
          }
        }
        ?>
      </tbody>
    </table>`
  <?php
  } else {
  ?>
    <table class="table table-hover table-bordered table-sm">
      <thead>
        <tr>
          <th>id</th>
          <th>Voucher No </th>
          <th>Name</th>
          <th>Item Name</th>
          <th>Trans. date</th>
          <th>Quanitity</th>
          <th>Unit Price</th>
          <th>Total Price</th>
          <th>Status</th>
          <th>Return</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $batch_no = 0;
        $sql = "SELECT invoice_detail.id, invoice_detail.item_no, invoice_detail.gl_acc_code, invoice_detail.order_date,invoice_detail.order_no, invoice_detail.item_unit, invoice_detail.item_qty AS item_qty,invoice_detail.unit_price_loc as unit_price_loc, invoice_detail.total_price_loc as total_price_loc, invoice_detail.bill_status, invoice_detail.item_status, item.item_name as item_name FROM invoice_detail JOIN item WHERE invoice_detail.item_no=item.id AND invoice_detail.order_type='SV'";
        $query = $conn->query($sql);
        while ($row = $query->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $row['id'] . '</td>';
          if ($row['order_no'] == $row['order_no']) {
            echo '<td>' . $row['order_no'] . '</td>';
          } else {
            echo "";
          }
          if ($row['gl_acc_code'] > 0) {
            echo '<td>' . $row['gl_acc_code'] . '</td>';
          } else {
            echo "";
          }
          echo '<td>' . $row['item_name'] . '</td>';
          echo '<td>' . $row['order_date'] . '</td>';
          echo '<td>' . $row['item_qty'] . '</td>';
          echo '<td>' . $row['unit_price_loc'] . '</td>';
          echo '<td>' . $row['total_price_loc'] . '</td>';
          // status
          if ($row['item_status'] == '2') {
            echo '<td><button class="btn btn-danger btn-sm" onclick="return false">Return Goods</button></td>';
          } elseif ($row['item_status'] == '3') {
            echo '<td><button class="btn btn-success btn-sm" onclick="return false"> Payment</button></td>';
          } else {
            echo '<td><button class="btn btn-info btn-sm" onclick="return false">Not Return Goods</button></td>';
          }
          // return 
          if ($row['item_status'] == '1') {
            echo '<td><a onclick="returnRow(' . $row["id"] . ',' . $row["order_no"] . ',' . $row["total_price_loc"] . ' )" class="btn btn-info fas fa-send-back">Return</a></td>';
          } elseif ($row['item_status'] == '3') {
            echo '<td><a class="btn btn-success fas fa-send-back" onclick="return false">Return</a></td>';
          } else {
            echo '<td><a class="btn btn-danger fas fa-send-back" onclick="return false">Return</a></td>';
          }
        }
        ?>
      </tbody>
    </table>
  <?php
  }
  ?>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- table  -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
</script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboard").addClass('active');
  });
  $(document).ready(function() {
    $("#1112000").addClass('active');
    $("#1100000").addClass('active');
    $("#1100000").addClass('is-expanded');
  });
</script>
<script>
  function returnRow(id, order_no, total) {
    // alert("hi"+id);
    if (confirm('Are you Return' + id + '____' + order_no + '____' + total + '??')) {
      $.ajax({
        url: 'return.php',
        method: 'POST',
        dataType: 'text',
        data: {
          id: id,
          order_no: order_no,
          total: total
        },
        success: function(response) {
          alert(response);
          location.reload();
        }
      });
    }
  }
</script>
</body>

</html>