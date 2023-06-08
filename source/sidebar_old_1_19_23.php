<?php
require '../database.php';
?>
<?php
function get_menus()
{
  require '../database.php';
  $id = $_SESSION['id'];
  $sql = "SELECT sm_role_dtl.role_no, sm_role_dtl.menu_no, sm_role_dtl.menu_name, sm_role_dtl.menu_obj_name,sm_role_dtl.main_id,sm_role_dtl.p_menu_no, sm_role_dtl.active_stat, user_info.id, user_info.username, user_info.sa_role_no FROM sm_role_dtl, user_info WHERE sm_role_dtl.role_no=user_info.sa_role_no AND user_info.id=$id AND sm_role_dtl.active_stat = 1";
//   echo $sql;
//   exit;
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result)) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $rows = $rows;
    $id = '';
    echo '<ul class="app-menu">';
    foreach ($rows as $row) {
      if ($row['p_menu_no'] == 0) {
?>
        <!-- main menu -->
        <li id="<?php echo $row['main_id']; ?>"><a class="app-menu__item" id="<?php echo $row['menu_no']; ?>" target="" href="../index/window.php?id=<?php echo $row['main_id']; ?>"><i class="app-menu__icon fa fa-hand-o-right"></i><span class="app-menu__label" ><?php echo $row['menu_name']; ?></span><i class="treeview-indicator fa fa-angle-right"></i></a></li>
      <?php
        $id = $row['main_id'];

        // sub($rows, $id);

      } else {
      }
    }
  }
}
function sub($rows, $id)
{
  foreach ($rows as $row) {
    if ($row['p_menu_no'] == $id) {
      ?>

<?php
    }
  }
}
echo '</ul>';
?>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay sidebardisplay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="../upload/<?php echo $_SESSION['employee_image']; ?>" height="50px" width="50px" alt="User Image">
    <div>
      <p class="app-sidebar__user-name">User:- <?php echo $_SESSION['username']; ?></p>
      <p class="app-sidebar__user-designation">Date:- <?php echo $_SESSION['org_eod_bod_proceorg_date']; ?><?php
                                                                                                            if (isset($_SESSION['sa_role_no'])) {
                                                                                                              $idno = $_SESSION['sa_role_no'];
                                                                                                              $query = "Select role_no,role_name From sm_role where role_no=$idno";
                                                                                                    
                                                                                                              $returnD = mysqli_query($conn, $query);
                                                                                                              $result = mysqli_fetch_assoc($returnD);
                                                                                                              $maxRows = $result['role_name'];
                                                                                                            }
                                                                                                            ?></p>
      <p class="app-sidebar__user-designation">Role:- <?php echo $maxRows; ?></p>
    </div>
  </div>
  <ul class="app-menu">
    <li><a class="app-menu__item" id="dashboard" href="../index/index.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
    <!-- sample menu -->
    <?php get_menus(); ?>
    <li class="treeview"><a class="app-menu__item" href="../transation/day_closed.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Day Closed</span></i></a>
    </li>
  </ul>
</aside>