<?php
require '../auth/auth.php';
require '../database.php';

$output = '';
if(isset($_POST["query"]))
{
	$search = $_POST["query"];
	$query = "SELECT * FROM gl_acc_code WHERE acc_code LIKE '%".$search."%' OR acc_head LIKE '%".$search."%' OR acc_level LIKE '%".$search."%' OR category_code LIKE '%".$search."%' OR postable_acc LIKE '%".$search."%'";
}
else
{
	$query = "SELECT * FROM gl_acc_code ORDER BY acc_code";
}
// $result = mysqli_query($conn, $query);
$result = $conn->query($query);
if(mysqli_num_rows($result) > 0)
{
    ?>
   <table style="width:100%" border="1">
                    <thead>
                        <tr style="text-align:center">
                            <th>A/C Head</th>
                            <th>Account No</th>
                            <th>Level</th>
                            <th>Category</th>
                            <th>postable_acc</th>
                        </tr>
                    </thead>
                    <tbody style="margin-left: 60px">
                        <?php
                        // $sql = "SELECT * from `gl_acc_code` ORDER BY `acc_code`";
                        // $result = $conn->query($sql);
                        // while($row = mysqli_fetch_array($result)){
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <?php
                                if ($row['acc_level'] == 1) {

                                ?>
                                    <td><?php echo $row['acc_code']; ?></td>
                                    <td style="color:red; font-weight:bold"><?php echo $row['acc_head']; ?></td>

                                    <td><?php echo $row['acc_level']; ?></td>
                                    <td><?php echo $row['category_code']; ?></td>
                                    <td><?php echo $row['postable_acc']; ?></td>
                                <?php
                                } elseif ($row['acc_level'] == 2) {
                                ?>
                                    <td><?php echo $row['acc_code']; ?></td>
                                    <td style="text-indent:20px;color:gray; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['acc_level']; ?></td>
                                    <td><?php echo $row['category_code']; ?></td>
                                    <td><?php echo $row['postable_acc']; ?></td>

                                <?php
                                } elseif ($row['acc_level'] == 3) {
                                ?>
                                    <td><?php echo $row['acc_code']; ?></td>
                                    <td style="text-indent:30px;color:blue; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['acc_level']; ?></td>
                                    <td><?php echo $row['category_code']; ?></td>
                                    <td><?php echo $row['postable_acc']; ?></td>
                                <?php
                                } elseif ($row['acc_level'] == 4) {
                                ?>
                                    <td><?php echo $row['acc_code']; ?></td>
                                    <td style="text-indent:40px;color:green; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['acc_level']; ?></td>
                                    <td><?php echo $row['category_code']; ?></td>
                                    <td><?php echo $row['postable_acc']; ?></td>
                                <?php
                                } else {
                                ?>
                                    <td><?php echo $row['acc_code']; ?></td>
                                    <td style="text-indent:20px"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['acc_level']; ?></td>
                                    <td><?php echo $row['category_code']; ?></td>
                                    <td><?php echo $row['postable_acc']; ?></td>
                                <?php
                                }
                                ?>
                            <?php
                        }
                            ?>

                    </tbody>
                </table>


    <?php
}
else
{
	echo 'Data Not Found';
}
?>