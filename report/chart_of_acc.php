<?php
require "../auth/auth.php";
include('../database.php');
$org_name = $_SESSION['org_name'];
$org_logo = $_SESSION['org_logo'];
$q = $_SESSION['org_rep_footer1'];
$b = $_SESSION['org_rep_footer2'];
$org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
$output = '';
$output .= $org;
$output .= '<h3 style="text-align:center">Chart of Account</h3>';
  ?>


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
                        <?php
                        $sql = "SELECT * from `gl_acc_code` ORDER BY `acc_code`";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                                if ($row['acc_level'] == 1) {
                                  $output .=  "<tr>
                                    <td>". $row['acc_code']."</td>
                                    <td style='color:red; font-weight:bold'>". $row['acc_head']."</td>
                                    <td>". $row['acc_level']."</td>
                                    <td>". $row['category_code']."</td>
                                    <td>". $row['postable_acc']."</td>
                                    </tr>";
                                } elseif ($row['acc_level'] == 2) {
                                  $output .=  "<tr><td>". $row['acc_code']."</td>
                                    <td style='text-indent:20px;color:gray; font-weight:bold'>". $row['acc_head']."</td>
                                    <td>". $row['acc_level']."</td>
                                    <td>". $row['category_code']."</td>
                                    <td>". $row['postable_acc']."</td>
                                    </tr>";
                                } elseif ($row['acc_level'] == 3) {
                                  $output .=  "<tr><td>". $row['acc_code']."</td>
                                    <td style='text-indent:30px;color:blue; font-weight:bold'>". $row['acc_head']."</td>
                                    <td>". $row['acc_level']."</td>
                                    <td>". $row['category_code']."</td>
                                    <td>". $row['postable_acc']."</td>
                                    </tr>";
                                } elseif ($row['acc_level'] == 4) {
                                  $output .=  "<tr><td>". $row['acc_code']."</td>
                                    <td style='text-indent:40px;color:green; font-weight:bold'>". $row['acc_head']."</td>
                                    <td>". $row['acc_level']."</td>
                                    <td>". $row['category_code']."</td>
                                    <td>". $row['postable_acc']."</td>
                                    </tr>";
                                } else {
                                  $output .=  "<tr><td>". $row['acc_code']."</td>
                                    <td style='text-indent:20px'>". $row['acc_head']."</td>
                                    <td>". $row['acc_level']."</td>
                                    <td>". $row['category_code']."</td>
                                    <td>". $row['postable_acc']."</td>
                                    </tr>";
                                }
                        }
                   echo $output;

                            ?>
                    </tbody>
                </table>
