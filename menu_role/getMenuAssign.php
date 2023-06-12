<?php
require "../auth/auth.php";
require '../database.php';

$output = '';
?>
<form method="POST">
    <!-- <table class="table bg-light table-bordered table-sm"> -->
    <table style="width:100%" class="bor">
        <thead>
            <tr>
            <th>Sub Menu No.</th>
            <th>Sub Menu Name</th>
            <th>active status</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $id = $_POST['p_menu_no'];
           
            $sql = "SELECT * from view_role where p_menu_no='$id' or id='$id'";
            $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
            ?>
                            <tr>  
                                    <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $row['office_code']; ?>" style="width: 100%" readonly>
                                    <input type="hidden" name="id[]" class="form-control" value="<?php echo $row['id']; ?>" style="width: 100%" readonly>
                                    <input type="hidden" name="menu_obj_name[]" class="form-control" value="<?php echo $row['menu_obj_name']; ?>" style="width: 100%" readonly>
                                    <input type="hidden" name="role_no[]" class="form-control" value="<?php echo $row['role_no']; ?>" style="width: 100%" readonly>
                                    <input type="hidden" name="p_menu_no[]" class="form-control" value="<?php echo $row['p_menu_no']; ?>" style="width: 100%" readonly>
                                   <td>
                                    <input type="text" name="menu_no[]" class="form-control" value="<?php echo $row['menu_no']; ?>" style="width: 100%" readonly>
                                   </td>
                                   <td>
                                    <input type="text" name="menu_name[]" class="form-control" value="<?php echo $row['menu_name']; ?>" style="width: 100%" readonly>
                                   </td>
                                  
                                       
                            <td>
                                <select name="active_stat[]" class="form-control" style="color: lightblue width: 100px">
                                    <option value="1" <?php if ($row['active_stat'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                    <option value="0" <?php if ($row['active_stat'] == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
                                </select>
                            </td>
                        </tr>
                <?php
                    }
                ?>
        </tbody>
    </table>

    <div>
            <label for="">Confirm  Role </label>
        
            <select name="grand_role" class="" id="grand_role" >
                    <option value="">- Select Role -</option>
                    <?php
                    $selectQuery = 'SELECT role_no , role_name FROM `sm_role`';
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                        echo '<option value="' . $row['role_no'] . '">' . $row['role_name'] . '</option>';
                      }
                    }
                    ?>
                  </select>
        </div>
    <input name="assignServices" type="submit" id="submit" value="Assigned Services" class="btn btn-info pull-right submit" />
<?php
            
?>
</form>

