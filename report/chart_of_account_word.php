<?php
require "../auth/auth.php";
require '../database.php';
$timestamp = time();
$filename = 'chart_of_account_word-' . $timestamp . '.doc';
header("Content-type: application/vnd.ms-word");
// header("Content-Disposition: attachment;Filename=" . rand() . ".doc");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");
?>
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <?php
            require '../report/report_header.php';
            ?>
            <h3 style="text-align:center">Chart of Account</h3>
            <div class="row">
                <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
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
                        <!-- <td><strong> level 1</strong></td>z -->
                        <?php
                        $sql = "SELECT * from `gl_acc_code` ORDER BY `acc_code`";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
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
            </div>
        </div>
    </div>
    </div>
</main>
</body>

</html>