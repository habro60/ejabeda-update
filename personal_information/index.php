<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>

<style>
   /* button.btn.btn-success.px-3.test {
    padding: 60px 110px 40px !important;
    margin-bottom: 26px;
    margin-right: 40px;
}
i.far.fa-thumbs-up.test2 {
    font-size: xxx-large;
}
   button.btn.btn-info.px-3.test3 {
    padding: 60px 110px 40px !important;
    margin-bottom: 26px;
    margin-right: 40px;
}
i.fas.fa-tint.test4 {
    font-size: xxx-large;
}
   button.btn.btn-warning.px-3.test5 {
    padding: 60px 110px 40px !important;
    margin-bottom: 26px;
    margin-right: 40px;
}
i.fas.fa-bolt.test6 {
    font-size: xxx-large;
}
   button.btn.btn-danger.px-3.test7 {
    padding: 60px 110px 40px !important;
    margin-bottom: 26px;
    margin-right: 40px;
}
i.fas.fa-users.test8 {
    font-size: xxx-large;
} */

a.btn.btn-success.px-3.test {
    padding-right: 60px !important;
    padding-top: 60px;
    padding-bottom: 60px;
    padding-left: 60px !important;
    margin-right: 30px !important;
    margin-bottom: 20px;
}
a.btn.btn-info.px-3.test2 {
    padding-right: 60px !important;
    padding-top: 60px;
    padding-bottom: 60px;
    padding-left: 60px !important;
    margin-right: 30px !important;
    margin-bottom: 20px;
}
a.btn.btn-warning.px-3.test3 {
    padding-right: 60px !important;
    padding-top: 60px;
    padding-bottom: 60px;
    padding-left: 60px !important;
    margin-right: 30px !important;
    margin-bottom: 20px;
}
a.btn.btn-danger.px-3.test4 {
    padding-right: 60px !important;
    padding-top: 60px;
    padding-bottom: 60px;
    padding-left: 60px !important;
    margin-right: 30px !important;
    margin-bottom: 20px;
}



</style>



<!-- write your contant start -->
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      <p></p>
      <!-- logged in user information -->
      <p style="color:red">Welcome Accounting Managemet Software</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#"><?php echo $_SESSION['office_code']; ?></a></li>
    </ul>
  </div>
  
<div class="row">

    <div class="col-12 text-center">


        <a href="personal_cash_income.php"class="btn btn-success px-3 test" data-toggle="tooltip" title="নগদ জমা">নগদ জমা</a>
        <a href="personal_cash_expense.php"class="btn btn-info px-3 test2" data-toggle="tooltip" title="নগদ খরচ">নগদ খরচ</a>
        <a href="personal_bank_income.php"class="btn btn-warning px-3 test3" data-toggle="tooltip" title="ব্যাংক জমা">ব্যাংক জমা</a>
        <a href="personal_bank_expense.php"class="btn btn-danger px-3 test4" data-toggle="tooltip" title="ব্যাংক খরচ">ব্যাংক খরচ</a>

        

    </div>

</div>

</main>
<!-- Write your contant end -->
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>

</body>

</html>