<?php
                require "../auth/auth.php";
                $q = $_GET['q'];
                include_once '../database.php';
                $sql = "SELECT * FROM `bank_acc_info` WHERE `bank_acc_no`='".$q."'";
                //use for MySQLi-OOP
                $query = $conn->query($sql);
                while ($row = $query->fetch_assoc()) {
                    ?>
                      <!-- Bank Code  -->
                      <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Bank</label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="bank_code" class="form-control" id="" value="<?php echo $row['bank_code']; ?>" readonly >
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="bank_name" class="form-control" id="" value="<?php echo $row['bank_name']; ?>" readonly >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Branch name  -->
					      <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Branch</label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="branch_code" class="form-control" id="" value="<?php echo $row['branch_code']; ?>" readonly >
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="branch_name" class="form-control" id="" value="<?php echo $row['branch_name']; ?>" readonly >
                                    </div>
                                </div>

                            </div>

                        </div>
					<?php
                }
          ?>   