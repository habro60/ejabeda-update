<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $notice = $_POST['notice'];
    $ss_modifier = $_SESSION['username'];
    // $time = date("d:m:Y");
    $time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $updateAttendance = "UPDATE `apart_meeting_attendance` SET `meeting_time`=now(),`attend_date`=now(),`attend_time`=now(),`attend_status`='1',`ss_modifier`='$ss_modifier' WHERE id=$id and notice_no=$notice";
    $conn->query($updateAttendance);
    echo $time->format('h:i:s A');
}
if (!empty($_POST['notice_no'])) {
    $output = '';
    $notice_no = $_POST['notice_no'];
?>
    <table class="table table-hover table-bordered" id="noticeTable">
        <thead>
            <tr>
                <th>Notice No.</th>
                <th>Meeting Date</th>
                <th>Meeting Time</th>
                <th>Owner Name</th>
                <th>Attend Time</th>
                <th>Present</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT apart_meeting_attendance.id, apart_meeting_attendance.notice_no, apart_meeting_attendance.meeting_date,apart_meeting_attendance.meeting_time, apart_owner_info.owner_name, apart_meeting_attendance.owner_id, attend_status,apart_meeting_attendance.attend_date,apart_meeting_attendance.attend_time FROM `apart_meeting_attendance`,apart_owner_info WHERE apart_meeting_attendance.owner_id=apart_owner_info.owner_id AND apart_meeting_attendance.notice_no='$notice_no'";
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
            ?>
                <tr>
                    <td style="width: 120px"><input type="text" id="" class="form-control" name="notice_no" value="<?php echo $row['notice_no']; ?>" readonly></td>
                    <td style="width: 120px"> <input type="date" class="form-control" name="meeting_date" value="<?php echo $row['meeting_date']; ?>" readonly></td>

                    <td><input type="text" id="meeting_time" class="form-control" name="meeting_time" value="<?php echo $row['meeting_time']; ?>" readonly></td>
                    <td><input type="text" id="" class="form-control" name="owner_name" value="<?php echo $row['owner_name']; ?>" readonly></td>
                    
                    <td><input type="text" class="form-control" name="attend_time" id="attend_time<?php echo $row['id']; ?>" value="<?php echo $row['attend_time']; ?>" readonly></td>
                    <td><button type="button" <?php if ($row['attend_status'] == 1) {
                                                    echo "class='btn btn-primary'";
                                                } else {
                                                    echo "class='btn btn-warning'";
                                                } ?> style="width: 120px" id="present<?php echo $row['id']; ?>" data-toggle="modal" data-target="#exampleModalCenter" onclick="presentDialog('<?php echo $row['id']; ?>','<?php echo $row['notice_no']; ?>')" <?php if ($row['attend_status'] == 1) {
                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                } ?>><span class="fa fa-hand-o-right"></span> <?php if ($row['attend_status'] == 1) {
                                                                                                                                                                                                                                                                                                            echo "Present";
                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                            echo "Absent";
                                                                                                                                                                                                                                                                                                        } ?></button></td>

                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
}
