<?php
session_start();
require '../database.php';
// ======GET ITEM FROM ITEM TABLE
if (isset($_GET['id'])) {
    $selectQuery = "select * from `item` where id='" . $_GET['id'] . "'";
    $selectQueryReuslt = $conn->query($selectQuery);
    $row = $selectQueryReuslt->fetch_assoc();
}
$upload_dir = '../upload/';
if (isset($_POST['submit'])) {
    require '../database.php';
    // ==image name from form -name="image"==
    $imgName = $_FILES['image']['name'];
    $imgTmp = $_FILES['image']['tmp_name'];
    // ==How much image size from form $imgName == 
    $imgSize = $_FILES['image']['size'];
    // ==which EXTENSION in this image 
    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
    $userPic = time() . '_' . rand(1000, 9999) . '.' . $imgExt;
    unlink($upload_dir . $row['image']);
    move_uploaded_file($imgTmp, $upload_dir . $userPic);

    $name = $conn->escape_string($_POST['name']);
    $parent_id = $conn->escape_string($_POST['parent_id']);
    $item_category = $conn->escape_string($_POST['item_category']);
    $item_code = $conn->escape_string($_POST['item_code']);
    $unit = $conn->escape_string($_POST['unit']);
    $sku = $conn->escape_string($_POST['sku']);
    $barcode = $conn->escape_string($_POST['barcode']);
    $sellable_option = $conn->escape_string($_POST['sellable_option']);
    $texable_option = $conn->escape_string($_POST['texable_option']);
    $pack_size = $conn->escape_string($_POST['pack_size']);
    $country_of_origin = $conn->escape_string($_POST['country_of_origin']);
    $country_of_manufacture = $conn->escape_string($_POST['country_of_manufacture']);
    $country_of_assemble = $conn->escape_string($_POST['country_of_assemble']);
    $brand_name = $conn->escape_string($_POST['brand_name']);
    $model_name = $conn->escape_string($_POST['model_name']);

    $insertQuery = "UPDATE `item`  SET  `image`='$userPic',`item_name`='$name', `parent_id`='$parent_id', `item_category`='$item_category',`item_code`='$item_code', `unit`='$unit',`sku`='$sku', `barcode`='$barcode', `sellable_option`='$sellable_option',`texable_option`='$texable_option', `pack_size`='$pack_size', `country_of_origin`='$country_of_origin', `country_of_manufacture`='$country_of_manufacture',`country_of_assemble`='$country_of_assemble', `brand_name`='$brand_name', `model_name`='$model_name' WHERE id='" . $_GET['id'] . "'";
    // echo " $insertQuery";
    // exit;
    $conn->query($insertQuery);
    if ($conn->affected_rows == 1) {
        $message = 'Main Item Data update !!';
        header('refresh:2; item.php');
    } else {
        $message_failled = 'Failled !!';
    }
}


?>
<?php
require '../source/top.php';
?>

<?php
require '../source/header.php';
?>
<?php
require '../source/sidebar.php';
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Edit Item Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="maingl">
                    <div class="meddlegl">
                        <h4 style="text-align:center">Edit Item Name : <?php echo $row['item_name']; ?></h4>
                        <?php if (isset($message)) {
                            echo "<h5 style='color:red'> $message </h5>";
                        }
                        ?>
                    </div>
                </div>
                <br>
                <!-- form start  -->
                <form method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" class="form-control disabled" name="parent_id" value="<?php echo $row['id']; ?>" placeholder="Enter main item " required>
                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Image</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="file" name="image" value="<?php echo $row['image']; ?>" id="fileToUpload" class="form-control" placeholder="Image">
                        </div>
                        <label class="col-sm-2 col-form-label">Item Name</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" class="form-control" value="<?php echo $row['item_name']; ?>" name="name" placeholder="Enter item Name" required>
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Unit</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <select name="unit" class="form-control" id="unit">
                                <?php
                                $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`="UCODE" AND `softcode`>0';
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($ucode = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $ucode['description'] . '">' . $ucode['description'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label"> Item Category</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" class="form-control" value="<?php echo $row['item_name']; ?>" required>
                            <input type="hidden" class="form-control" value="<?php echo $row['item_category']; ?>" name="item_category" placeholder="Enter item Category" required>
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Code</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" class="form-control" name="item_code" value="<?php echo $row['item_code']; ?>" placeholder="Enter main Code " required>
                        </div>
                        <label class="col-sm-2 col-form-label">SKU</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" class="form-control" name="sku" value="<?php echo $row['sku']; ?>" placeholder="Enter main SKU ">
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Barcode</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" class="form-control" name="barcode" value="<?php echo $row['barcode']; ?>" placeholder="Enter item Barcode">
                        </div>
                        <label class="col-sm-2 col-form-label">Sellable Option</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <select name="sellable_option" id="" class="form-control">
                                <option value="">--- select ---</option>
                                <option value="Y" <?php if ($row['sellable_option'] == 'Y') echo 'selected'; ?>> Yes </option>
                                <option value="N" <?php if ($row['sellable_option'] == 'N') echo 'selected'; ?>> No </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Taxable Option</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <select name="texable_option" id="" class="form-control">
                                <option value="">--- select ---</option>
                                <option value="Y" <?php if ($row['texable_option'] == 'Y') echo 'selected'; ?>> Yes </option>
                                <option value="N" <?php if ($row['texable_option'] == 'N') echo 'selected'; ?>> No </option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">Pack Size</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" class="form-control" name="pack_size" value="<?php echo $row['pack_size']; ?>" placeholder="Enter Pack Size">
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Country of Origin
                        </label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <select name="country_of_origin" class="form-control select2">
                                <option <?php if ($row['country_of_origin'] == 'Afganistan') echo 'selected'; ?> value="Afganistan">Afghanistan</option>
                                <option <?php if ($row['country_of_origin'] == 'Albania') echo 'selected'; ?> value="Albania">Albania</option>
                                <option <?php if ($row['country_of_origin'] == 'Algeria') echo 'selected'; ?> value="Algeria">Algeria</option>
                                <option <?php if ($row['country_of_origin'] == 'American Samoa') echo 'selected'; ?> value="American Samoa">American Samoa</option>
                                <option <?php if ($row['country_of_origin'] == 'Andorra') echo 'selected'; ?> value="Andorra">Andorra</option>
                                <option <?php if ($row['country_of_origin'] == 'Angola') echo 'selected'; ?> value="Angola">Angola</option>
                                <option <?php if ($row['country_of_origin'] == 'Anguilla') echo 'selected'; ?> value="Anguilla">Anguilla</option>
                                <option <?php if ($row['country_of_origin'] == 'Antigua & Barbuda') echo 'selected'; ?> value="Antigua & Barbuda">Antigua & Barbuda</option>
                                <option <?php if ($row['country_of_origin'] == 'Argentina') echo 'selected'; ?> value="Argentina">Argentina</option>
                                <option <?php if ($row['country_of_origin'] == 'Armenia') echo 'selected'; ?> value="Armenia">Armenia</option>
                                <option <?php if ($row['country_of_origin'] == 'Aruba') echo 'selected'; ?> value="Aruba">Aruba</option>
                                <option <?php if ($row['country_of_origin'] == 'Australia') echo 'selected'; ?> value="Australia">Australia</option>
                                <option <?php if ($row['country_of_origin'] == 'Austria') echo 'selected'; ?> value="Austria">Austria</option>
                                <option <?php if ($row['country_of_origin'] == 'Azerbaijan') echo 'selected'; ?> value="Azerbaijan">Azerbaijan</option>
                                <option <?php if ($row['country_of_origin'] == 'Bahamas') echo 'selected'; ?> value="Bahamas">Bahamas</option>
                                <option <?php if ($row['country_of_origin'] == 'Bahrain') echo 'selected'; ?> value="Bahrain">Bahrain</option>
                                <option <?php if ($row['country_of_origin'] == 'Bangladesh') echo 'selected'; ?> value="Bangladesh">Bangladesh</option>
                                <option <?php if ($row['country_of_origin'] == 'Barbados') echo 'selected'; ?> value="Barbados">Barbados</option>
                                <option <?php if ($row['country_of_origin'] == 'Belarus') echo 'selected'; ?> value="Belarus">Belarus</option>
                                <option <?php if ($row['country_of_origin'] == 'Belgium') echo 'selected'; ?> value="Belgium">Belgium</option>
                                <option <?php if ($row['country_of_origin'] == 'Belize') echo 'selected'; ?> value="Belize">Belize</option>
                                <option <?php if ($row['country_of_origin'] == 'Benin') echo 'selected'; ?> value="Benin">Benin</option>
                                <option <?php if ($row['country_of_origin'] == 'Bermuda') echo 'selected'; ?> value="Bermuda">Bermuda</option>
                                <option <?php if ($row['country_of_origin'] == 'Bhutan') echo 'selected'; ?> value="Bhutan">Bhutan</option>
                                <option <?php if ($row['country_of_origin'] == 'Bolivia') echo 'selected'; ?> value="Bolivia">Bolivia</option>
                                <option <?php if ($row['country_of_origin'] == 'Bonaire') echo 'selected'; ?> value="Bonaire">Bonaire</option>
                                <option <?php if ($row['country_of_origin'] == 'Bosnia & Herzegovina') echo 'selected'; ?> value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                <option <?php if ($row['country_of_origin'] == 'Botswana') echo 'selected'; ?> value="Botswana">Botswana</option>
                                <option <?php if ($row['country_of_origin'] == 'Brazil') echo 'selected'; ?> value="Brazil">Brazil</option>
                                <option <?php if ($row['country_of_origin'] == 'British Indian Ocean') echo 'selected'; ?> value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                <option <?php if ($row['country_of_origin'] == 'Brunei') echo 'selected'; ?> value="Brunei">Brunei</option>
                                <option <?php if ($row['country_of_origin'] == 'Bulgaria') echo 'selected'; ?> value="Bulgaria">Bulgaria</option>
                                <option <?php if ($row['country_of_origin'] == 'Burkina Faso') echo 'selected'; ?> value="Burkina Faso">Burkina Faso</option>
                                <option <?php if ($row['country_of_origin'] == 'Burundi') echo 'selected'; ?> value="Burundi">Burundi</option>
                                <option <?php if ($row['country_of_origin'] == 'Cambodia') echo 'selected'; ?> value="Cambodia">Cambodia</option>
                                <option <?php if ($row['country_of_origin'] == 'Cameroon') echo 'selected'; ?> value="Cameroon">Cameroon</option>
                                <option <?php if ($row['country_of_origin'] == 'Canada') echo 'selected'; ?> value="Canada">Canada</option>
                                <option <?php if ($row['country_of_origin'] == 'Canary Islands') echo 'selected'; ?> value="Canary Islands">Canary Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Cape Verde') echo 'selected'; ?> value="Cape Verde">Cape Verde</option>
                                <option <?php if ($row['country_of_origin'] == 'Cayman Islands') echo 'selected'; ?> value="Cayman Islands">Cayman Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Central African Repub') echo 'selected'; ?> value="Central African Republic">Central African Republic</option>
                                <option <?php if ($row['country_of_origin'] == 'Chad') echo 'selected'; ?> value="Chad">Chad</option>
                                <option <?php if ($row['country_of_origin'] == 'Channel Islands') echo 'selected'; ?> value="Channel Islands">Channel Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Chile') echo 'selected'; ?> value="Chile">Chile</option>
                                <option <?php if ($row['country_of_origin'] == 'China') echo 'selected'; ?> value="China">China</option>
                                <option <?php if ($row['country_of_origin'] == 'Christmas Island') echo 'selected'; ?> value="Christmas Island">Christmas Island</option>
                                <option <?php if ($row['country_of_origin'] == 'Cocos Island') echo 'selected'; ?> value="Cocos Island">Cocos Island</option>
                                <option <?php if ($row['country_of_origin'] == 'Colombia') echo 'selected'; ?> value="Colombia">Colombia</option>
                                <option <?php if ($row['country_of_origin'] == 'Comoros') echo 'selected'; ?> value="Comoros">Comoros</option>
                                <option <?php if ($row['country_of_origin'] == 'Congo') echo 'selected'; ?> value="Congo">Congo</option>
                                <option <?php if ($row['country_of_origin'] == 'Cook Islands') echo 'selected'; ?> value="Cook Islands">Cook Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Costa Rica') echo 'selected'; ?> value="Costa Rica">Costa Rica</option>
                                <option <?php if ($row['country_of_origin'] == 'Cote DIvoire') echo 'selected'; ?> value="Cote DIvoire">Cote DIvoire</option>
                                <option <?php if ($row['country_of_origin'] == 'Croatia') echo 'selected'; ?> value="Croatia">Croatia</option>
                                <option <?php if ($row['country_of_origin'] == 'Cuba') echo 'selected'; ?> value="Cuba">Cuba</option>
                                <option <?php if ($row['country_of_origin'] == 'Curaco') echo 'selected'; ?> value="Curaco">Curacao</option>
                                <option <?php if ($row['country_of_origin'] == 'Cyprus') echo 'selected'; ?> value="Cyprus">Cyprus</option>
                                <option <?php if ($row['country_of_origin'] == 'Czech Republic') echo 'selected'; ?> value="Czech Republic">Czech Republic</option>
                                <option <?php if ($row['country_of_origin'] == 'Denmark') echo 'selected'; ?> value="Denmark">Denmark</option>
                                <option <?php if ($row['country_of_origin'] == 'Djibouti') echo 'selected'; ?> value="Djibouti">Djibouti</option>
                                <option <?php if ($row['country_of_origin'] == 'Dominica') echo 'selected'; ?> value="Dominica">Dominica</option>
                                <option <?php if ($row['country_of_origin'] == 'Dominican Republic') echo 'selected'; ?> value="Dominican Republic">Dominican Republic</option>
                                <option <?php if ($row['country_of_origin'] == 'East Timor') echo 'selected'; ?> value="East Timor">East Timor</option>
                                <option <?php if ($row['country_of_origin'] == 'Ecuador') echo 'selected'; ?> value="Ecuador">Ecuador</option>
                                <option <?php if ($row['country_of_origin'] == 'Egypt') echo 'selected'; ?> value="Egypt">Egypt</option>
                                <option <?php if ($row['country_of_origin'] == 'El Salvador') echo 'selected'; ?> value="El Salvador">El Salvador</option>
                                <option <?php if ($row['country_of_origin'] == 'Equatorial Guinea') echo 'selected'; ?> value="Equatorial Guinea">Equatorial Guinea</option>
                                <option <?php if ($row['country_of_origin'] == 'Eritrea') echo 'selected'; ?> value="Eritrea">Eritrea</option>
                                <option <?php if ($row['country_of_origin'] == 'Estonia') echo 'selected'; ?> value="Estonia">Estonia</option>
                                <option <?php if ($row['country_of_origin'] == 'Ethiopia') echo 'selected'; ?> value="Ethiopia">Ethiopia</option>
                                <option <?php if ($row['country_of_origin'] == 'Falkland Islands') echo 'selected'; ?> value="Falkland Islands">Falkland Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Faroe Islands') echo 'selected'; ?> value="Faroe Islands">Faroe Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Fiji') echo 'selected'; ?> value="Fiji">Fiji</option>
                                <option <?php if ($row['country_of_origin'] == 'Finland') echo 'selected'; ?> value="Finland">Finland</option>
                                <option <?php if ($row['country_of_origin'] == 'France') echo 'selected'; ?> value="France">France</option>
                                <option <?php if ($row['country_of_origin'] == 'French Guiana') echo 'selected'; ?> value="French Guiana">French Guiana</option>
                                <option <?php if ($row['country_of_origin'] == 'French Polynesia') echo 'selected'; ?> value="French Polynesia">French Polynesia</option>
                                <option <?php if ($row['country_of_origin'] == 'French Southern Ter') echo 'selected'; ?> value="French Southern Ter">French Southern Ter</option>
                                <option <?php if ($row['country_of_origin'] == 'Gabon') echo 'selected'; ?> value="Gabon">Gabon</option>
                                <option <?php if ($row['country_of_origin'] == 'Gambia') echo 'selected'; ?> value="Gambia">Gambia</option>
                                <option <?php if ($row['country_of_origin'] == 'Georgia') echo 'selected'; ?> value="Georgia">Georgia</option>
                                <option <?php if ($row['country_of_origin'] == 'Germany') echo 'selected'; ?> value="Germany">Germany</option>
                                <option <?php if ($row['country_of_origin'] == 'Ghana') echo 'selected'; ?> value="Ghana">Ghana</option>
                                <option <?php if ($row['country_of_origin'] == 'Gibraltar') echo 'selected'; ?> value="Gibraltar">Gibraltar</option>
                                <option <?php if ($row['country_of_origin'] == 'Great Britain') echo 'selected'; ?> value="Great Britain">Great Britain</option>
                                <option <?php if ($row['country_of_origin'] == 'Greece') echo 'selected'; ?> value="Greece">Greece</option>
                                <option <?php if ($row['country_of_origin'] == 'Greenland') echo 'selected'; ?> value="Greenland">Greenland</option>
                                <option <?php if ($row['country_of_origin'] == 'Grenada') echo 'selected'; ?> value="Grenada">Grenada</option>
                                <option <?php if ($row['country_of_origin'] == 'Guadeloupe') echo 'selected'; ?> value="Guadeloupe">Guadeloupe</option>
                                <option <?php if ($row['country_of_origin'] == 'Guam') echo 'selected'; ?> value="Guam">Guam</option>
                                <option <?php if ($row['country_of_origin'] == 'Guatemala') echo 'selected'; ?> value="Guatemala">Guatemala</option>
                                <option <?php if ($row['country_of_origin'] == 'Guinea') echo 'selected'; ?> value="Guinea">Guinea</option>
                                <option <?php if ($row['country_of_origin'] == 'Guyana') echo 'selected'; ?> value="Guyana">Guyana</option>
                                <option <?php if ($row['country_of_origin'] == 'Haiti') echo 'selected'; ?> value="Haiti">Haiti</option>
                                <option <?php if ($row['country_of_origin'] == 'Hawaii') echo 'selected'; ?> value="Hawaii">Hawaii</option>
                                <option <?php if ($row['country_of_origin'] == 'Honduras') echo 'selected'; ?> value="Honduras">Honduras</option>
                                <option <?php if ($row['country_of_origin'] == 'Hong Kong') echo 'selected'; ?> value="Hong Kong">Hong Kong</option>
                                <option <?php if ($row['country_of_origin'] == 'Hungary') echo 'selected'; ?> value="Hungary">Hungary</option>
                                <option <?php if ($row['country_of_origin'] == 'Iceland') echo 'selected'; ?> value="Iceland">Iceland</option>
                                <option <?php if ($row['country_of_origin'] == 'Indonesia') echo 'selected'; ?> value="Indonesia">Indonesia</option>
                                <option <?php if ($row['country_of_origin'] == 'India">India</option>') echo 'selected'; ?> value="India">India</option>
                                <option <?php if ($row['country_of_origin'] == 'Iran') echo 'selected'; ?> value="Iran">Iran</option>
                                <option <?php if ($row['country_of_origin'] == 'Iraq') echo 'selected'; ?> value="Iraq">Iraq</option>
                                <option <?php if ($row['country_of_origin'] == 'Ireland') echo 'selected'; ?> value="Ireland">Ireland</option>
                                <option <?php if ($row['country_of_origin'] == 'Isle of Man') echo 'selected'; ?> value="Isle of Man">Isle of Man</option>
                                <option <?php if ($row['country_of_origin'] == 'Italy') echo 'selected'; ?> value="Italy">Italy</option>
                                <option <?php if ($row['country_of_origin'] == 'Jamaica') echo 'selected'; ?> value="Jamaica">Jamaica</option>
                                <option <?php if ($row['country_of_origin'] == 'Japan') echo 'selected'; ?> value="Japan">Japan</option>
                                <option <?php if ($row['country_of_origin'] == 'Jordan') echo 'selected'; ?> value="Jordan">Jordan</option>
                                <option <?php if ($row['country_of_origin'] == 'Kazakhstan') echo 'selected'; ?> value="Kazakhstan">Kazakhstan</option>
                                <option <?php if ($row['country_of_origin'] == 'Kenya') echo 'selected'; ?> value="Kenya">Kenya</option>
                                <option <?php if ($row['country_of_origin'] == 'Kiribati">Kiribati</o') echo 'selected'; ?> value="Kiribati">Kiribati</option>
                                <option <?php if ($row['country_of_origin'] == 'Korea North') echo 'selected'; ?> value="Korea North">Korea North</option>
                                <option <?php if ($row['country_of_origin'] == 'Korea Sout') echo 'selected'; ?> value="Korea Sout">Korea South</option>
                                <option <?php if ($row['country_of_origin'] == 'Kuwait') echo 'selected'; ?> value="Kuwait">Kuwait</option>
                                <option <?php if ($row['country_of_origin'] == 'Kyrgyzstan') echo 'selected'; ?> value="Kyrgyzstan">Kyrgyzstan</option>
                                <option <?php if ($row['country_of_origin'] == 'Laos') echo 'selected'; ?> value="Laos">Laos</option>
                                <option <?php if ($row['country_of_origin'] == 'Latvia') echo 'selected'; ?> value="Latvia">Latvia</option>
                                <option <?php if ($row['country_of_origin'] == 'Lebanon') echo 'selected'; ?> value="Lebanon">Lebanon</option>
                                <option <?php if ($row['country_of_origin'] == 'Lesotho') echo 'selected'; ?> value="Lesotho">Lesotho</option>
                                <option <?php if ($row['country_of_origin'] == 'Liberia') echo 'selected'; ?> value="Liberia">Liberia</option>
                                <option <?php if ($row['country_of_origin'] == 'Libya') echo 'selected'; ?> value="Libya">Libya</option>
                                <option <?php if ($row['country_of_origin'] == 'Liechtenstein') echo 'selected'; ?> value="Liechtenstein">Liechtenstein</option>
                                <option <?php if ($row['country_of_origin'] == 'Lithuania') echo 'selected'; ?> value="Lithuania">Lithuania</option>
                                <option <?php if ($row['country_of_origin'] == 'Luxembourg') echo 'selected'; ?> value="Luxembourg">Luxembourg</option>
                                <option <?php if ($row['country_of_origin'] == 'Macau') echo 'selected'; ?> value="Macau">Macau</option>
                                <option <?php if ($row['country_of_origin'] == 'Macedonia') echo 'selected'; ?> value="Macedonia">Macedonia</option>
                                <option <?php if ($row['country_of_origin'] == 'Madagascar') echo 'selected'; ?> value="Madagascar">Madagascar</option>
                                <option <?php if ($row['country_of_origin'] == 'Malaysia') echo 'selected'; ?> value="Malaysia">Malaysia</option>
                                <option <?php if ($row['country_of_origin'] == 'Malawi') echo 'selected'; ?> value="Malawi">Malawi</option>
                                <option <?php if ($row['country_of_origin'] == 'Maldives') echo 'selected'; ?> value="Maldives">Maldives</option>
                                <option <?php if ($row['country_of_origin'] == 'Mali') echo 'selected'; ?> value="Mali">Mali</option>
                                <option <?php if ($row['country_of_origin'] == 'Malta') echo 'selected'; ?> value="Malta">Malta</option>
                                <option <?php if ($row['country_of_origin'] == 'Marshall Islands') echo 'selected'; ?> value="Marshall Islands">Marshall Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Martinique') echo 'selected'; ?> value="Martinique">Martinique</option>
                                <option <?php if ($row['country_of_origin'] == 'Mauritania') echo 'selected'; ?> value="Mauritania">Mauritania</option>
                                <option <?php if ($row['country_of_origin'] == 'Mauritius') echo 'selected'; ?> value="Mauritius">Mauritius</option>
                                <option <?php if ($row['country_of_origin'] == 'Mayotte') echo 'selected'; ?> value="Mayotte">Mayotte</option>
                                <option <?php if ($row['country_of_origin'] == 'Mexico') echo 'selected'; ?> value="Mexico">Mexico</option>
                                <option <?php if ($row['country_of_origin'] == 'Midway Islands') echo 'selected'; ?> value="Midway Islands">Midway Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Moldova') echo 'selected'; ?> value="Moldova">Moldova</option>
                                <option <?php if ($row['country_of_origin'] == 'Monaco') echo 'selected'; ?> value="Monaco">Monaco</option>
                                <option <?php if ($row['country_of_origin'] == 'Mongolia') echo 'selected'; ?> value="Mongolia">Mongolia</option>
                                <option <?php if ($row['country_of_origin'] == 'Montserrat') echo 'selected'; ?> value="Montserrat">Montserrat</option>
                                <option <?php if ($row['country_of_origin'] == 'Morocco') echo 'selected'; ?> value="Morocco">Morocco</option>
                                <option <?php if ($row['country_of_origin'] == 'Mozambique') echo 'selected'; ?> value="Mozambique">Mozambique</option>
                                <option <?php if ($row['country_of_origin'] == 'Myanmar') echo 'selected'; ?> value="Myanmar">Myanmar</option>
                                <option <?php if ($row['country_of_origin'] == 'Nambia') echo 'selected'; ?> value="Nambia">Nambia</option>
                                <option <?php if ($row['country_of_origin'] == 'Nauru') echo 'selected'; ?> value="Nauru">Nauru</option>
                                <option <?php if ($row['country_of_origin'] == 'Nepal') echo 'selected'; ?> value="Nepal">Nepal</option>
                                <option <?php if ($row['country_of_origin'] == 'Netherland Antilles') echo 'selected'; ?> value="Netherland Antilles">Netherland Antilles</option>
                                <option <?php if ($row['country_of_origin'] == 'Netherlands') echo 'selected'; ?> value="Netherlands">Netherlands (Holland, Europe)</option>
                                <option <?php if ($row['country_of_origin'] == 'Nevis') echo 'selected'; ?> value="Nevis">Nevis</option>
                                <option <?php if ($row['country_of_origin'] == 'New Caledonia') echo 'selected'; ?> value="New Caledonia">New Caledonia</option>
                                <option <?php if ($row['country_of_origin'] == 'New Zealand') echo 'selected'; ?> value="New Zealand">New Zealand</option>
                                <option <?php if ($row['country_of_origin'] == 'Nicaragua') echo 'selected'; ?> value="Nicaragua">Nicaragua</option>
                                <option <?php if ($row['country_of_origin'] == 'Niger') echo 'selected'; ?> value="Niger">Niger</option>
                                <option <?php if ($row['country_of_origin'] == 'Nigeria') echo 'selected'; ?> value="Nigeria">Nigeria</option>
                                <option <?php if ($row['country_of_origin'] == 'Niue') echo 'selected'; ?> value="Niue">Niue</option>
                                <option <?php if ($row['country_of_origin'] == 'Norfolk Island') echo 'selected'; ?> value="Norfolk Island">Norfolk Island</option>
                                <option <?php if ($row['country_of_origin'] == 'Norway') echo 'selected'; ?> value="Norway">Norway</option>
                                <option <?php if ($row['country_of_origin'] == 'Oman') echo 'selected'; ?> value="Oman">Oman</option>
                                <option <?php if ($row['country_of_origin'] == 'Pakistan') echo 'selected'; ?> value="Pakistan">Pakistan</option>
                                <option <?php if ($row['country_of_origin'] == 'Palau Island">Palau I') echo 'selected'; ?> value="Palau Island">Palau Island</option>
                                <option <?php if ($row['country_of_origin'] == 'Palestine') echo 'selected'; ?> value="Palestine">Palestine</option>
                                <option <?php if ($row['country_of_origin'] == 'Panama') echo 'selected'; ?> value="Panama">Panama</option>
                                <option <?php if ($row['country_of_origin'] == 'Papua New Guinea') echo 'selected'; ?> value="Papua New Guinea">Papua New Guinea</option>
                                <option <?php if ($row['country_of_origin'] == 'Paraguay') echo 'selected'; ?> value="Paraguay">Paraguay</option>
                                <option <?php if ($row['country_of_origin'] == 'Peru') echo 'selected'; ?> value="Peru">Peru</option>
                                <option <?php if ($row['country_of_origin'] == 'Phillipines') echo 'selected'; ?> value="Phillipines">Philippines</option>
                                <option <?php if ($row['country_of_origin'] == 'Pitcairn Island') echo 'selected'; ?> value="Pitcairn Island">Pitcairn Island</option>
                                <option <?php if ($row['country_of_origin'] == 'Poland') echo 'selected'; ?> value="Poland">Poland</option>
                                <option <?php if ($row['country_of_origin'] == 'Portugal') echo 'selected'; ?> value="Portugal">Portugal</option>
                                <option <?php if ($row['country_of_origin'] == 'Puerto Rico') echo 'selected'; ?> value="Puerto Rico">Puerto Rico</option>
                                <option <?php if ($row['country_of_origin'] == 'Qatar') echo 'selected'; ?> value="Qatar">Qatar</option>
                                <option <?php if ($row['country_of_origin'] == 'Republic of Montenegr') echo 'selected'; ?> value="Republic of Montenegro">Republic of Montenegro</option>
                                <option <?php if ($row['country_of_origin'] == 'Republic of Serbia') echo 'selected'; ?> value="Republic of Serbia">Republic of Serbia</option>
                                <option <?php if ($row['country_of_origin'] == 'Reunion') echo 'selected'; ?> value="Reunion">Reunion</option>
                                <option <?php if ($row['country_of_origin'] == 'Romania') echo 'selected'; ?> value="Romania">Romania</option>
                                <option <?php if ($row['country_of_origin'] == 'Russia') echo 'selected'; ?> value="Russia">Russia</option>
                                <option <?php if ($row['country_of_origin'] == 'Rwanda') echo 'selected'; ?> value="Rwanda">Rwanda</option>
                                <option <?php if ($row['country_of_origin'] == 'St Barthelemy') echo 'selected'; ?> value="St Barthelemy">St Barthelemy</option>
                                <option <?php if ($row['country_of_origin'] == 'St Eustatius') echo 'selected'; ?> value="St Eustatius">St Eustatius</option>
                                <option <?php if ($row['country_of_origin'] == 'St Helena') echo 'selected'; ?> value="St Helena">St Helena</option>
                                <option <?php if ($row['country_of_origin'] == 'St Kitts-Nevis') echo 'selected'; ?> value="St Kitts-Nevis">St Kitts-Nevis</option>
                                <option <?php if ($row['country_of_origin'] == 'St Lucia') echo 'selected'; ?> value="St Lucia">St Lucia</option>
                                <option <?php if ($row['country_of_origin'] == 'St Maarten') echo 'selected'; ?> value="St Maarten">St Maarten</option>
                                <option <?php if ($row['country_of_origin'] == 'St Pierre & Miquelon') echo 'selected'; ?> value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                <option <?php if ($row['country_of_origin'] == 'St Vincent & Grenadin') echo 'selected'; ?> value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                <option <?php if ($row['country_of_origin'] == 'Saipan') echo 'selected'; ?> value="Saipan">Saipan</option>
                                <option <?php if ($row['country_of_origin'] == 'Samoa') echo 'selected'; ?> value="Samoa">Samoa</option>
                                <option <?php if ($row['country_of_origin'] == 'Samoa American') echo 'selected'; ?> value="Samoa American">Samoa American</option>
                                <option <?php if ($row['country_of_origin'] == 'San Marino') echo 'selected'; ?> value="San Marino">San Marino</option>
                                <option <?php if ($row['country_of_origin'] == 'Sao Tome & Principe') echo 'selected'; ?> value="Sao Tome & Principe">Sao Tome & Principe</option>
                                <option <?php if ($row['country_of_origin'] == 'Saudi Arabia') echo 'selected'; ?> value="Saudi Arabia">Saudi Arabia</option>
                                <option <?php if ($row['country_of_origin'] == 'Senegal') echo 'selected'; ?> value="Senegal">Senegal</option>
                                <option <?php if ($row['country_of_origin'] == 'Seychelles') echo 'selected'; ?> value="Seychelles">Seychelles</option>
                                <option <?php if ($row['country_of_origin'] == 'Sierra Leone') echo 'selected'; ?> value="Sierra Leone">Sierra Leone</option>
                                <option <?php if ($row['country_of_origin'] == 'Singapore') echo 'selected'; ?> value="Singapore">Singapore</option>
                                <option <?php if ($row['country_of_origin'] == 'Slovakia') echo 'selected'; ?> value="Slovakia">Slovakia</option>
                                <option <?php if ($row['country_of_origin'] == 'Slovenia') echo 'selected'; ?> value="Slovenia">Slovenia</option>
                                <option <?php if ($row['country_of_origin'] == 'Solomon Islands') echo 'selected'; ?> value="Solomon Islands">Solomon Islands</option>
                                <option <?php if ($row['country_of_origin'] == 'Somalia') echo 'selected'; ?> value="Somalia">Somalia</option>
                                <option <?php if ($row['country_of_origin'] == 'South Africa') echo 'selected'; ?> value="South Africa">South Africa</option>
                                <option <?php if ($row['country_of_origin'] == 'Spain') echo 'selected'; ?> value="Spain">Spain</option>
                                <option <?php if ($row['country_of_origin'] == 'Sri Lanka') echo 'selected'; ?> value="Sri Lanka">Sri Lanka</option>
                                <option <?php if ($row['country_of_origin'] == 'Sudan') echo 'selected'; ?> value="Sudan">Sudan</option>
                                <option <?php if ($row['country_of_origin'] == 'Suriname') echo 'selected'; ?> value="Suriname">Suriname</option>
                                <option <?php if ($row['country_of_origin'] == 'Swaziland') echo 'selected'; ?> value="Swaziland">Swaziland</option>
                                <option <?php if ($row['country_of_origin'] == 'Sweden') echo 'selected'; ?> value="Sweden">Sweden</option>
                                <option <?php if ($row['country_of_origin'] == 'Switzerland') echo 'selected'; ?> value="Switzerland">Switzerland</option>
                                <option <?php if ($row['country_of_origin'] == 'Syria') echo 'selected'; ?> value="Syria">Syria</option>
                                <option <?php if ($row['country_of_origin'] == 'Tahiti') echo 'selected'; ?> value="Tahiti">Tahiti</option>
                                <option <?php if ($row['country_of_origin'] == 'Taiwan') echo 'selected'; ?> value="Taiwan">Taiwan</option>
                                <option <?php if ($row['country_of_origin'] == 'Tajikistan') echo 'selected'; ?> value="Tajikistan">Tajikistan</option>
                                <option <?php if ($row['country_of_origin'] == 'Tanzania') echo 'selected'; ?> value="Tanzania">Tanzania</option>
                                <option <?php if ($row['country_of_origin'] == 'Thailand') echo 'selected'; ?> value="Thailand">Thailand</option>
                                <option <?php if ($row['country_of_origin'] == 'Togo') echo 'selected'; ?> value="Togo">Togo</option>
                                <option <?php if ($row['country_of_origin'] == 'Tokelau') echo 'selected'; ?> value="Tokelau">Tokelau</option>
                                <option <?php if ($row['country_of_origin'] == 'Tonga') echo 'selected'; ?> value="Tonga">Tonga</option>
                                <option <?php if ($row['country_of_origin'] == 'Trinidad & Tobago') echo 'selected'; ?> value="Trinidad & Tobago">Trinidad & Tobago</option>
                                <option <?php if ($row['country_of_origin'] == 'Tunisia') echo 'selected'; ?> value="Tunisia">Tunisia</option>
                                <option <?php if ($row['country_of_origin'] == 'Turkey') echo 'selected'; ?> value="Turkey">Turkey</option>
                                <option <?php if ($row['country_of_origin'] == 'Turkmenistan') echo 'selected'; ?> value="Turkmenistan">Turkmenistan</option>
                                <option <?php if ($row['country_of_origin'] == 'Turks & Caicos Is') echo 'selected'; ?> value="Turks & Caicos Is">Turks & Caicos Is</option>
                                <option <?php if ($row['country_of_origin'] == 'Tuvalu') echo 'selected'; ?> value="Tuvalu">Tuvalu</option>
                                <option <?php if ($row['country_of_origin'] == 'Uganda') echo 'selected'; ?> value="Uganda">Uganda</option>
                                <option <?php if ($row['country_of_origin'] == 'United Kingdom') echo 'selected'; ?> value="United Kingdom">United Kingdom</option>
                                <option <?php if ($row['country_of_origin'] == 'Ukraine') echo 'selected'; ?> value="Ukraine">Ukraine</option>
                                <option <?php if ($row['country_of_origin'] == 'United Arab Erimates') echo 'selected'; ?> value="United Arab Erimates">United Arab Emirates</option>
                                <option <?php if ($row['country_of_origin'] == 'United States of Amer') echo 'selected'; ?> value="United States of America">United States of America</option>
                                <option <?php if ($row['country_of_origin'] == 'Uraguay') echo 'selected'; ?> value="Uraguay">Uruguay</option>
                                <option <?php if ($row['country_of_origin'] == 'Uzbekistan') echo 'selected'; ?> value="Uzbekistan">Uzbekistan</option>
                                <option <?php if ($row['country_of_origin'] == 'Vanuatu') echo 'selected'; ?> value="Vanuatu">Vanuatu</option>
                                <option <?php if ($row['country_of_origin'] == 'Vatican City State') echo 'selected'; ?> value="Vatican City State">Vatican City State</option>
                                <option <?php if ($row['country_of_origin'] == 'Venezuela') echo 'selected'; ?> value="Venezuela">Venezuela</option>
                                <option <?php if ($row['country_of_origin'] == 'Vietnam') echo 'selected'; ?> value="Vietnam">Vietnam</option>
                                <option <?php if ($row['country_of_origin'] == 'Virgin Islands (Brit)') echo 'selected'; ?> value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                <option <?php if ($row['country_of_origin'] == 'Virgin Islands (USA)') echo 'selected'; ?> value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                <option <?php if ($row['country_of_origin'] == 'Wake Island">Wake Isl') echo 'selected'; ?> value="Wake Island">Wake Island</option>
                                <option <?php if ($row['country_of_origin'] == 'Wallis & Futana Is') echo 'selected'; ?> value="Wallis & Futana Is">Wallis & Futana Is</option>
                                <option <?php if ($row['country_of_origin'] == 'Yemen') echo 'selected'; ?> value="Yemen">Yemen</option>
                                <option <?php if ($row['country_of_origin'] == 'Zaire') echo 'selected'; ?> value="Zaire">Zaire</option>
                                <option <?php if ($row['country_of_origin'] == 'Zambia') echo 'selected'; ?> value="Zambia">Zambia</option>
                                <option <?php if ($row['country_of_origin'] == 'Zimbabwe') echo 'selected'; ?> value="Zimbabwe">Zimbabwe</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">Country of Menufacture
                        </label>
                        <label class="col-form-label">:</label>
                        <div class="col">

                            <select name="country_of_manufacture" class="form-control select2">
                                <option <?php if ($row['country_of_manufacture'] == 'Afganistan') echo 'selected'; ?> value="Afganistan">Afghanistan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Albania') echo 'selected'; ?> value="Albania">Albania</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Algeria') echo 'selected'; ?> value="Algeria">Algeria</option>
                                <option <?php if ($row['country_of_manufacture'] == 'American Samoa') echo 'selected'; ?> value="American Samoa">American Samoa</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Andorra') echo 'selected'; ?> value="Andorra">Andorra</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Angola') echo 'selected'; ?> value="Angola">Angola</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Anguilla') echo 'selected'; ?> value="Anguilla">Anguilla</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Antigua & Barbuda') echo 'selected'; ?> value="Antigua & Barbuda">Antigua & Barbuda</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Argentina') echo 'selected'; ?> value="Argentina">Argentina</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Armenia') echo 'selected'; ?> value="Armenia">Armenia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Aruba') echo 'selected'; ?> value="Aruba">Aruba</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Australia') echo 'selected'; ?> value="Australia">Australia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Austria') echo 'selected'; ?> value="Austria">Austria</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Azerbaijan') echo 'selected'; ?> value="Azerbaijan">Azerbaijan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bahamas') echo 'selected'; ?> value="Bahamas">Bahamas</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bahrain') echo 'selected'; ?> value="Bahrain">Bahrain</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bangladesh') echo 'selected'; ?> value="Bangladesh">Bangladesh</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Barbados') echo 'selected'; ?> value="Barbados">Barbados</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Belarus') echo 'selected'; ?> value="Belarus">Belarus</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Belgium') echo 'selected'; ?> value="Belgium">Belgium</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Belize') echo 'selected'; ?> value="Belize">Belize</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Benin') echo 'selected'; ?> value="Benin">Benin</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bermuda') echo 'selected'; ?> value="Bermuda">Bermuda</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bhutan') echo 'selected'; ?> value="Bhutan">Bhutan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bolivia') echo 'selected'; ?> value="Bolivia">Bolivia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bonaire') echo 'selected'; ?> value="Bonaire">Bonaire</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bosnia & Herzegovina') echo 'selected'; ?> value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Botswana') echo 'selected'; ?> value="Botswana">Botswana</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Brazil') echo 'selected'; ?> value="Brazil">Brazil</option>
                                <option <?php if ($row['country_of_manufacture'] == 'British Indian Ocean') echo 'selected'; ?> value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Brunei') echo 'selected'; ?> value="Brunei">Brunei</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Bulgaria') echo 'selected'; ?> value="Bulgaria">Bulgaria</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Burkina Faso') echo 'selected'; ?> value="Burkina Faso">Burkina Faso</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Burundi') echo 'selected'; ?> value="Burundi">Burundi</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cambodia') echo 'selected'; ?> value="Cambodia">Cambodia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cameroon') echo 'selected'; ?> value="Cameroon">Cameroon</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Canada') echo 'selected'; ?> value="Canada">Canada</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Canary Islands') echo 'selected'; ?> value="Canary Islands">Canary Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cape Verde') echo 'selected'; ?> value="Cape Verde">Cape Verde</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cayman Islands') echo 'selected'; ?> value="Cayman Islands">Cayman Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Central African Repub') echo 'selected'; ?> value="Central African Republic">Central African Republic</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Chad') echo 'selected'; ?> value="Chad">Chad</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Channel Islands') echo 'selected'; ?> value="Channel Islands">Channel Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Chile') echo 'selected'; ?> value="Chile">Chile</option>
                                <option <?php if ($row['country_of_manufacture'] == 'China') echo 'selected'; ?> value="China">China</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Christmas Island') echo 'selected'; ?> value="Christmas Island">Christmas Island</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cocos Island') echo 'selected'; ?> value="Cocos Island">Cocos Island</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Colombia') echo 'selected'; ?> value="Colombia">Colombia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Comoros') echo 'selected'; ?> value="Comoros">Comoros</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Congo') echo 'selected'; ?> value="Congo">Congo</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cook Islands') echo 'selected'; ?> value="Cook Islands">Cook Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Costa Rica') echo 'selected'; ?> value="Costa Rica">Costa Rica</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cote DIvoire') echo 'selected'; ?> value="Cote DIvoire">Cote DIvoire</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Croatia') echo 'selected'; ?> value="Croatia">Croatia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cuba') echo 'selected'; ?> value="Cuba">Cuba</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Curaco') echo 'selected'; ?> value="Curaco">Curacao</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Cyprus') echo 'selected'; ?> value="Cyprus">Cyprus</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Czech Republic') echo 'selected'; ?> value="Czech Republic">Czech Republic</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Denmark') echo 'selected'; ?> value="Denmark">Denmark</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Djibouti') echo 'selected'; ?> value="Djibouti">Djibouti</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Dominica') echo 'selected'; ?> value="Dominica">Dominica</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Dominican Republic') echo 'selected'; ?> value="Dominican Republic">Dominican Republic</option>
                                <option <?php if ($row['country_of_manufacture'] == 'East Timor') echo 'selected'; ?> value="East Timor">East Timor</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Ecuador') echo 'selected'; ?> value="Ecuador">Ecuador</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Egypt') echo 'selected'; ?> value="Egypt">Egypt</option>
                                <option <?php if ($row['country_of_manufacture'] == 'El Salvador') echo 'selected'; ?> value="El Salvador">El Salvador</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Equatorial Guinea') echo 'selected'; ?> value="Equatorial Guinea">Equatorial Guinea</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Eritrea') echo 'selected'; ?> value="Eritrea">Eritrea</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Estonia') echo 'selected'; ?> value="Estonia">Estonia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Ethiopia') echo 'selected'; ?> value="Ethiopia">Ethiopia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Falkland Islands') echo 'selected'; ?> value="Falkland Islands">Falkland Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Faroe Islands') echo 'selected'; ?> value="Faroe Islands">Faroe Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Fiji') echo 'selected'; ?> value="Fiji">Fiji</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Finland') echo 'selected'; ?> value="Finland">Finland</option>
                                <option <?php if ($row['country_of_manufacture'] == 'France') echo 'selected'; ?> value="France">France</option>
                                <option <?php if ($row['country_of_manufacture'] == 'French Guiana') echo 'selected'; ?> value="French Guiana">French Guiana</option>
                                <option <?php if ($row['country_of_manufacture'] == 'French Polynesia') echo 'selected'; ?> value="French Polynesia">French Polynesia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'French Southern Ter') echo 'selected'; ?> value="French Southern Ter">French Southern Ter</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Gabon') echo 'selected'; ?> value="Gabon">Gabon</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Gambia') echo 'selected'; ?> value="Gambia">Gambia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Georgia') echo 'selected'; ?> value="Georgia">Georgia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Germany') echo 'selected'; ?> value="Germany">Germany</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Ghana') echo 'selected'; ?> value="Ghana">Ghana</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Gibraltar') echo 'selected'; ?> value="Gibraltar">Gibraltar</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Great Britain') echo 'selected'; ?> value="Great Britain">Great Britain</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Greece') echo 'selected'; ?> value="Greece">Greece</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Greenland') echo 'selected'; ?> value="Greenland">Greenland</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Grenada') echo 'selected'; ?> value="Grenada">Grenada</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Guadeloupe') echo 'selected'; ?> value="Guadeloupe">Guadeloupe</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Guam') echo 'selected'; ?> value="Guam">Guam</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Guatemala') echo 'selected'; ?> value="Guatemala">Guatemala</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Guinea') echo 'selected'; ?> value="Guinea">Guinea</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Guyana') echo 'selected'; ?> value="Guyana">Guyana</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Haiti') echo 'selected'; ?> value="Haiti">Haiti</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Hawaii') echo 'selected'; ?> value="Hawaii">Hawaii</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Honduras') echo 'selected'; ?> value="Honduras">Honduras</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Hong Kong') echo 'selected'; ?> value="Hong Kong">Hong Kong</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Hungary') echo 'selected'; ?> value="Hungary">Hungary</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Iceland') echo 'selected'; ?> value="Iceland">Iceland</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Indonesia') echo 'selected'; ?> value="Indonesia">Indonesia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'India">India</option>') echo 'selected'; ?> value="India">India</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Iran') echo 'selected'; ?> value="Iran">Iran</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Iraq') echo 'selected'; ?> value="Iraq">Iraq</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Ireland') echo 'selected'; ?> value="Ireland">Ireland</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Isle of Man') echo 'selected'; ?> value="Isle of Man">Isle of Man</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Italy') echo 'selected'; ?> value="Italy">Italy</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Jamaica') echo 'selected'; ?> value="Jamaica">Jamaica</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Japan') echo 'selected'; ?> value="Japan">Japan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Jordan') echo 'selected'; ?> value="Jordan">Jordan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Kazakhstan') echo 'selected'; ?> value="Kazakhstan">Kazakhstan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Kenya') echo 'selected'; ?> value="Kenya">Kenya</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Kiribati">Kiribati</o') echo 'selected'; ?> value="Kiribati">Kiribati</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Korea North') echo 'selected'; ?> value="Korea North">Korea North</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Korea Sout') echo 'selected'; ?> value="Korea Sout">Korea South</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Kuwait') echo 'selected'; ?> value="Kuwait">Kuwait</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Kyrgyzstan') echo 'selected'; ?> value="Kyrgyzstan">Kyrgyzstan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Laos') echo 'selected'; ?> value="Laos">Laos</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Latvia') echo 'selected'; ?> value="Latvia">Latvia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Lebanon') echo 'selected'; ?> value="Lebanon">Lebanon</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Lesotho') echo 'selected'; ?> value="Lesotho">Lesotho</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Liberia') echo 'selected'; ?> value="Liberia">Liberia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Libya') echo 'selected'; ?> value="Libya">Libya</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Liechtenstein') echo 'selected'; ?> value="Liechtenstein">Liechtenstein</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Lithuania') echo 'selected'; ?> value="Lithuania">Lithuania</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Luxembourg') echo 'selected'; ?> value="Luxembourg">Luxembourg</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Macau') echo 'selected'; ?> value="Macau">Macau</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Macedonia') echo 'selected'; ?> value="Macedonia">Macedonia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Madagascar') echo 'selected'; ?> value="Madagascar">Madagascar</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Malaysia') echo 'selected'; ?> value="Malaysia">Malaysia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Malawi') echo 'selected'; ?> value="Malawi">Malawi</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Maldives') echo 'selected'; ?> value="Maldives">Maldives</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Mali') echo 'selected'; ?> value="Mali">Mali</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Malta') echo 'selected'; ?> value="Malta">Malta</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Marshall Islands') echo 'selected'; ?> value="Marshall Islands">Marshall Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Martinique') echo 'selected'; ?> value="Martinique">Martinique</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Mauritania') echo 'selected'; ?> value="Mauritania">Mauritania</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Mauritius') echo 'selected'; ?> value="Mauritius">Mauritius</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Mayotte') echo 'selected'; ?> value="Mayotte">Mayotte</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Mexico') echo 'selected'; ?> value="Mexico">Mexico</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Midway Islands') echo 'selected'; ?> value="Midway Islands">Midway Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Moldova') echo 'selected'; ?> value="Moldova">Moldova</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Monaco') echo 'selected'; ?> value="Monaco">Monaco</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Mongolia') echo 'selected'; ?> value="Mongolia">Mongolia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Montserrat') echo 'selected'; ?> value="Montserrat">Montserrat</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Morocco') echo 'selected'; ?> value="Morocco">Morocco</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Mozambique') echo 'selected'; ?> value="Mozambique">Mozambique</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Myanmar') echo 'selected'; ?> value="Myanmar">Myanmar</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Nambia') echo 'selected'; ?> value="Nambia">Nambia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Nauru') echo 'selected'; ?> value="Nauru">Nauru</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Nepal') echo 'selected'; ?> value="Nepal">Nepal</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Netherland Antilles') echo 'selected'; ?> value="Netherland Antilles">Netherland Antilles</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Netherlands') echo 'selected'; ?> value="Netherlands">Netherlands (Holland, Europe)</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Nevis') echo 'selected'; ?> value="Nevis">Nevis</option>
                                <option <?php if ($row['country_of_manufacture'] == 'New Caledonia') echo 'selected'; ?> value="New Caledonia">New Caledonia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'New Zealand') echo 'selected'; ?> value="New Zealand">New Zealand</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Nicaragua') echo 'selected'; ?> value="Nicaragua">Nicaragua</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Niger') echo 'selected'; ?> value="Niger">Niger</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Nigeria') echo 'selected'; ?> value="Nigeria">Nigeria</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Niue') echo 'selected'; ?> value="Niue">Niue</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Norfolk Island') echo 'selected'; ?> value="Norfolk Island">Norfolk Island</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Norway') echo 'selected'; ?> value="Norway">Norway</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Oman') echo 'selected'; ?> value="Oman">Oman</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Pakistan') echo 'selected'; ?> value="Pakistan">Pakistan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Palau Island">Palau I') echo 'selected'; ?> value="Palau Island">Palau Island</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Palestine') echo 'selected'; ?> value="Palestine">Palestine</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Panama') echo 'selected'; ?> value="Panama">Panama</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Papua New Guinea') echo 'selected'; ?> value="Papua New Guinea">Papua New Guinea</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Paraguay') echo 'selected'; ?> value="Paraguay">Paraguay</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Peru') echo 'selected'; ?> value="Peru">Peru</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Phillipines') echo 'selected'; ?> value="Phillipines">Philippines</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Pitcairn Island') echo 'selected'; ?> value="Pitcairn Island">Pitcairn Island</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Poland') echo 'selected'; ?> value="Poland">Poland</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Portugal') echo 'selected'; ?> value="Portugal">Portugal</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Puerto Rico') echo 'selected'; ?> value="Puerto Rico">Puerto Rico</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Qatar') echo 'selected'; ?> value="Qatar">Qatar</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Republic of Montenegr') echo 'selected'; ?> value="Republic of Montenegro">Republic of Montenegro</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Republic of Serbia') echo 'selected'; ?> value="Republic of Serbia">Republic of Serbia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Reunion') echo 'selected'; ?> value="Reunion">Reunion</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Romania') echo 'selected'; ?> value="Romania">Romania</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Russia') echo 'selected'; ?> value="Russia">Russia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Rwanda') echo 'selected'; ?> value="Rwanda">Rwanda</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Barthelemy') echo 'selected'; ?> value="St Barthelemy">St Barthelemy</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Eustatius') echo 'selected'; ?> value="St Eustatius">St Eustatius</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Helena') echo 'selected'; ?> value="St Helena">St Helena</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Kitts-Nevis') echo 'selected'; ?> value="St Kitts-Nevis">St Kitts-Nevis</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Lucia') echo 'selected'; ?> value="St Lucia">St Lucia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Maarten') echo 'selected'; ?> value="St Maarten">St Maarten</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Pierre & Miquelon') echo 'selected'; ?> value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                <option <?php if ($row['country_of_manufacture'] == 'St Vincent & Grenadin') echo 'selected'; ?> value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Saipan') echo 'selected'; ?> value="Saipan">Saipan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Samoa') echo 'selected'; ?> value="Samoa">Samoa</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Samoa American') echo 'selected'; ?> value="Samoa American">Samoa American</option>
                                <option <?php if ($row['country_of_manufacture'] == 'San Marino') echo 'selected'; ?> value="San Marino">San Marino</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Sao Tome & Principe') echo 'selected'; ?> value="Sao Tome & Principe">Sao Tome & Principe</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Saudi Arabia') echo 'selected'; ?> value="Saudi Arabia">Saudi Arabia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Senegal') echo 'selected'; ?> value="Senegal">Senegal</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Seychelles') echo 'selected'; ?> value="Seychelles">Seychelles</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Sierra Leone') echo 'selected'; ?> value="Sierra Leone">Sierra Leone</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Singapore') echo 'selected'; ?> value="Singapore">Singapore</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Slovakia') echo 'selected'; ?> value="Slovakia">Slovakia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Slovenia') echo 'selected'; ?> value="Slovenia">Slovenia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Solomon Islands') echo 'selected'; ?> value="Solomon Islands">Solomon Islands</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Somalia') echo 'selected'; ?> value="Somalia">Somalia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'South Africa') echo 'selected'; ?> value="South Africa">South Africa</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Spain') echo 'selected'; ?> value="Spain">Spain</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Sri Lanka') echo 'selected'; ?> value="Sri Lanka">Sri Lanka</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Sudan') echo 'selected'; ?> value="Sudan">Sudan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Suriname') echo 'selected'; ?> value="Suriname">Suriname</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Swaziland') echo 'selected'; ?> value="Swaziland">Swaziland</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Sweden') echo 'selected'; ?> value="Sweden">Sweden</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Switzerland') echo 'selected'; ?> value="Switzerland">Switzerland</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Syria') echo 'selected'; ?> value="Syria">Syria</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Tahiti') echo 'selected'; ?> value="Tahiti">Tahiti</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Taiwan') echo 'selected'; ?> value="Taiwan">Taiwan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Tajikistan') echo 'selected'; ?> value="Tajikistan">Tajikistan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Tanzania') echo 'selected'; ?> value="Tanzania">Tanzania</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Thailand') echo 'selected'; ?> value="Thailand">Thailand</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Togo') echo 'selected'; ?> value="Togo">Togo</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Tokelau') echo 'selected'; ?> value="Tokelau">Tokelau</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Tonga') echo 'selected'; ?> value="Tonga">Tonga</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Trinidad & Tobago') echo 'selected'; ?> value="Trinidad & Tobago">Trinidad & Tobago</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Tunisia') echo 'selected'; ?> value="Tunisia">Tunisia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Turkey') echo 'selected'; ?> value="Turkey">Turkey</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Turkmenistan') echo 'selected'; ?> value="Turkmenistan">Turkmenistan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Turks & Caicos Is') echo 'selected'; ?> value="Turks & Caicos Is">Turks & Caicos Is</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Tuvalu') echo 'selected'; ?> value="Tuvalu">Tuvalu</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Uganda') echo 'selected'; ?> value="Uganda">Uganda</option>
                                <option <?php if ($row['country_of_manufacture'] == 'United Kingdom') echo 'selected'; ?> value="United Kingdom">United Kingdom</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Ukraine') echo 'selected'; ?> value="Ukraine">Ukraine</option>
                                <option <?php if ($row['country_of_manufacture'] == 'United Arab Erimates') echo 'selected'; ?> value="United Arab Erimates">United Arab Emirates</option>
                                <option <?php if ($row['country_of_manufacture'] == 'United States of Amer') echo 'selected'; ?> value="United States of America">United States of America</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Uraguay') echo 'selected'; ?> value="Uraguay">Uruguay</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Uzbekistan') echo 'selected'; ?> value="Uzbekistan">Uzbekistan</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Vanuatu') echo 'selected'; ?> value="Vanuatu">Vanuatu</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Vatican City State') echo 'selected'; ?> value="Vatican City State">Vatican City State</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Venezuela') echo 'selected'; ?> value="Venezuela">Venezuela</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Vietnam') echo 'selected'; ?> value="Vietnam">Vietnam</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Virgin Islands (Brit)') echo 'selected'; ?> value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Virgin Islands (USA)') echo 'selected'; ?> value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Wake Island">Wake Isl') echo 'selected'; ?> value="Wake Island">Wake Island</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Wallis & Futana Is') echo 'selected'; ?> value="Wallis & Futana Is">Wallis & Futana Is</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Yemen') echo 'selected'; ?> value="Yemen">Yemen</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Zaire') echo 'selected'; ?> value="Zaire">Zaire</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Zambia') echo 'selected'; ?> value="Zambia">Zambia</option>
                                <option <?php if ($row['country_of_manufacture'] == 'Zimbabwe') echo 'selected'; ?> value="Zimbabwe">Zimbabwe</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Country of Assembly</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <select name="country_of_assemble" class="form-control select2">
                                <option <?php if ($row['country_of_assemble'] == 'Afganistan') echo 'selected'; ?> value="Afganistan">Afghanistan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Albania') echo 'selected'; ?> value="Albania">Albania</option>
                                <option <?php if ($row['country_of_assemble'] == 'Algeria') echo 'selected'; ?> value="Algeria">Algeria</option>
                                <option <?php if ($row['country_of_assemble'] == 'American Samoa') echo 'selected'; ?> value="American Samoa">American Samoa</option>
                                <option <?php if ($row['country_of_assemble'] == 'Andorra') echo 'selected'; ?> value="Andorra">Andorra</option>
                                <option <?php if ($row['country_of_assemble'] == 'Angola') echo 'selected'; ?> value="Angola">Angola</option>
                                <option <?php if ($row['country_of_assemble'] == 'Anguilla') echo 'selected'; ?> value="Anguilla">Anguilla</option>
                                <option <?php if ($row['country_of_assemble'] == 'Antigua & Barbuda') echo 'selected'; ?> value="Antigua & Barbuda">Antigua & Barbuda</option>
                                <option <?php if ($row['country_of_assemble'] == 'Argentina') echo 'selected'; ?> value="Argentina">Argentina</option>
                                <option <?php if ($row['country_of_assemble'] == 'Armenia') echo 'selected'; ?> value="Armenia">Armenia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Aruba') echo 'selected'; ?> value="Aruba">Aruba</option>
                                <option <?php if ($row['country_of_assemble'] == 'Australia') echo 'selected'; ?> value="Australia">Australia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Austria') echo 'selected'; ?> value="Austria">Austria</option>
                                <option <?php if ($row['country_of_assemble'] == 'Azerbaijan') echo 'selected'; ?> value="Azerbaijan">Azerbaijan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bahamas') echo 'selected'; ?> value="Bahamas">Bahamas</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bahrain') echo 'selected'; ?> value="Bahrain">Bahrain</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bangladesh') echo 'selected'; ?> value="Bangladesh">Bangladesh</option>
                                <option <?php if ($row['country_of_assemble'] == 'Barbados') echo 'selected'; ?> value="Barbados">Barbados</option>
                                <option <?php if ($row['country_of_assemble'] == 'Belarus') echo 'selected'; ?> value="Belarus">Belarus</option>
                                <option <?php if ($row['country_of_assemble'] == 'Belgium') echo 'selected'; ?> value="Belgium">Belgium</option>
                                <option <?php if ($row['country_of_assemble'] == 'Belize') echo 'selected'; ?> value="Belize">Belize</option>
                                <option <?php if ($row['country_of_assemble'] == 'Benin') echo 'selected'; ?> value="Benin">Benin</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bermuda') echo 'selected'; ?> value="Bermuda">Bermuda</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bhutan') echo 'selected'; ?> value="Bhutan">Bhutan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bolivia') echo 'selected'; ?> value="Bolivia">Bolivia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bonaire') echo 'selected'; ?> value="Bonaire">Bonaire</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bosnia & Herzegovina') echo 'selected'; ?> value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                <option <?php if ($row['country_of_assemble'] == 'Botswana') echo 'selected'; ?> value="Botswana">Botswana</option>
                                <option <?php if ($row['country_of_assemble'] == 'Brazil') echo 'selected'; ?> value="Brazil">Brazil</option>
                                <option <?php if ($row['country_of_assemble'] == 'British Indian Ocean') echo 'selected'; ?> value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                <option <?php if ($row['country_of_assemble'] == 'Brunei') echo 'selected'; ?> value="Brunei">Brunei</option>
                                <option <?php if ($row['country_of_assemble'] == 'Bulgaria') echo 'selected'; ?> value="Bulgaria">Bulgaria</option>
                                <option <?php if ($row['country_of_assemble'] == 'Burkina Faso') echo 'selected'; ?> value="Burkina Faso">Burkina Faso</option>
                                <option <?php if ($row['country_of_assemble'] == 'Burundi') echo 'selected'; ?> value="Burundi">Burundi</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cambodia') echo 'selected'; ?> value="Cambodia">Cambodia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cameroon') echo 'selected'; ?> value="Cameroon">Cameroon</option>
                                <option <?php if ($row['country_of_assemble'] == 'Canada') echo 'selected'; ?> value="Canada">Canada</option>
                                <option <?php if ($row['country_of_assemble'] == 'Canary Islands') echo 'selected'; ?> value="Canary Islands">Canary Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cape Verde') echo 'selected'; ?> value="Cape Verde">Cape Verde</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cayman Islands') echo 'selected'; ?> value="Cayman Islands">Cayman Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Central African Repub') echo 'selected'; ?> value="Central African Republic">Central African Republic</option>
                                <option <?php if ($row['country_of_assemble'] == 'Chad') echo 'selected'; ?> value="Chad">Chad</option>
                                <option <?php if ($row['country_of_assemble'] == 'Channel Islands') echo 'selected'; ?> value="Channel Islands">Channel Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Chile') echo 'selected'; ?> value="Chile">Chile</option>
                                <option <?php if ($row['country_of_assemble'] == 'China') echo 'selected'; ?> value="China">China</option>
                                <option <?php if ($row['country_of_assemble'] == 'Christmas Island') echo 'selected'; ?> value="Christmas Island">Christmas Island</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cocos Island') echo 'selected'; ?> value="Cocos Island">Cocos Island</option>
                                <option <?php if ($row['country_of_assemble'] == 'Colombia') echo 'selected'; ?> value="Colombia">Colombia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Comoros') echo 'selected'; ?> value="Comoros">Comoros</option>
                                <option <?php if ($row['country_of_assemble'] == 'Congo') echo 'selected'; ?> value="Congo">Congo</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cook Islands') echo 'selected'; ?> value="Cook Islands">Cook Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Costa Rica') echo 'selected'; ?> value="Costa Rica">Costa Rica</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cote DIvoire') echo 'selected'; ?> value="Cote DIvoire">Cote DIvoire</option>
                                <option <?php if ($row['country_of_assemble'] == 'Croatia') echo 'selected'; ?> value="Croatia">Croatia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cuba') echo 'selected'; ?> value="Cuba">Cuba</option>
                                <option <?php if ($row['country_of_assemble'] == 'Curaco') echo 'selected'; ?> value="Curaco">Curacao</option>
                                <option <?php if ($row['country_of_assemble'] == 'Cyprus') echo 'selected'; ?> value="Cyprus">Cyprus</option>
                                <option <?php if ($row['country_of_assemble'] == 'Czech Republic') echo 'selected'; ?> value="Czech Republic">Czech Republic</option>
                                <option <?php if ($row['country_of_assemble'] == 'Denmark') echo 'selected'; ?> value="Denmark">Denmark</option>
                                <option <?php if ($row['country_of_assemble'] == 'Djibouti') echo 'selected'; ?> value="Djibouti">Djibouti</option>
                                <option <?php if ($row['country_of_assemble'] == 'Dominica') echo 'selected'; ?> value="Dominica">Dominica</option>
                                <option <?php if ($row['country_of_assemble'] == 'Dominican Republic') echo 'selected'; ?> value="Dominican Republic">Dominican Republic</option>
                                <option <?php if ($row['country_of_assemble'] == 'East Timor') echo 'selected'; ?> value="East Timor">East Timor</option>
                                <option <?php if ($row['country_of_assemble'] == 'Ecuador') echo 'selected'; ?> value="Ecuador">Ecuador</option>
                                <option <?php if ($row['country_of_assemble'] == 'Egypt') echo 'selected'; ?> value="Egypt">Egypt</option>
                                <option <?php if ($row['country_of_assemble'] == 'El Salvador') echo 'selected'; ?> value="El Salvador">El Salvador</option>
                                <option <?php if ($row['country_of_assemble'] == 'Equatorial Guinea') echo 'selected'; ?> value="Equatorial Guinea">Equatorial Guinea</option>
                                <option <?php if ($row['country_of_assemble'] == 'Eritrea') echo 'selected'; ?> value="Eritrea">Eritrea</option>
                                <option <?php if ($row['country_of_assemble'] == 'Estonia') echo 'selected'; ?> value="Estonia">Estonia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Ethiopia') echo 'selected'; ?> value="Ethiopia">Ethiopia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Falkland Islands') echo 'selected'; ?> value="Falkland Islands">Falkland Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Faroe Islands') echo 'selected'; ?> value="Faroe Islands">Faroe Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Fiji') echo 'selected'; ?> value="Fiji">Fiji</option>
                                <option <?php if ($row['country_of_assemble'] == 'Finland') echo 'selected'; ?> value="Finland">Finland</option>
                                <option <?php if ($row['country_of_assemble'] == 'France') echo 'selected'; ?> value="France">France</option>
                                <option <?php if ($row['country_of_assemble'] == 'French Guiana') echo 'selected'; ?> value="French Guiana">French Guiana</option>
                                <option <?php if ($row['country_of_assemble'] == 'French Polynesia') echo 'selected'; ?> value="French Polynesia">French Polynesia</option>
                                <option <?php if ($row['country_of_assemble'] == 'French Southern Ter') echo 'selected'; ?> value="French Southern Ter">French Southern Ter</option>
                                <option <?php if ($row['country_of_assemble'] == 'Gabon') echo 'selected'; ?> value="Gabon">Gabon</option>
                                <option <?php if ($row['country_of_assemble'] == 'Gambia') echo 'selected'; ?> value="Gambia">Gambia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Georgia') echo 'selected'; ?> value="Georgia">Georgia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Germany') echo 'selected'; ?> value="Germany">Germany</option>
                                <option <?php if ($row['country_of_assemble'] == 'Ghana') echo 'selected'; ?> value="Ghana">Ghana</option>
                                <option <?php if ($row['country_of_assemble'] == 'Gibraltar') echo 'selected'; ?> value="Gibraltar">Gibraltar</option>
                                <option <?php if ($row['country_of_assemble'] == 'Great Britain') echo 'selected'; ?> value="Great Britain">Great Britain</option>
                                <option <?php if ($row['country_of_assemble'] == 'Greece') echo 'selected'; ?> value="Greece">Greece</option>
                                <option <?php if ($row['country_of_assemble'] == 'Greenland') echo 'selected'; ?> value="Greenland">Greenland</option>
                                <option <?php if ($row['country_of_assemble'] == 'Grenada') echo 'selected'; ?> value="Grenada">Grenada</option>
                                <option <?php if ($row['country_of_assemble'] == 'Guadeloupe') echo 'selected'; ?> value="Guadeloupe">Guadeloupe</option>
                                <option <?php if ($row['country_of_assemble'] == 'Guam') echo 'selected'; ?> value="Guam">Guam</option>
                                <option <?php if ($row['country_of_assemble'] == 'Guatemala') echo 'selected'; ?> value="Guatemala">Guatemala</option>
                                <option <?php if ($row['country_of_assemble'] == 'Guinea') echo 'selected'; ?> value="Guinea">Guinea</option>
                                <option <?php if ($row['country_of_assemble'] == 'Guyana') echo 'selected'; ?> value="Guyana">Guyana</option>
                                <option <?php if ($row['country_of_assemble'] == 'Haiti') echo 'selected'; ?> value="Haiti">Haiti</option>
                                <option <?php if ($row['country_of_assemble'] == 'Hawaii') echo 'selected'; ?> value="Hawaii">Hawaii</option>
                                <option <?php if ($row['country_of_assemble'] == 'Honduras') echo 'selected'; ?> value="Honduras">Honduras</option>
                                <option <?php if ($row['country_of_assemble'] == 'Hong Kong') echo 'selected'; ?> value="Hong Kong">Hong Kong</option>
                                <option <?php if ($row['country_of_assemble'] == 'Hungary') echo 'selected'; ?> value="Hungary">Hungary</option>
                                <option <?php if ($row['country_of_assemble'] == 'Iceland') echo 'selected'; ?> value="Iceland">Iceland</option>
                                <option <?php if ($row['country_of_assemble'] == 'Indonesia') echo 'selected'; ?> value="Indonesia">Indonesia</option>
                                <option <?php if ($row['country_of_assemble'] == 'India">India</option>') echo 'selected'; ?> value="India">India</option>
                                <option <?php if ($row['country_of_assemble'] == 'Iran') echo 'selected'; ?> value="Iran">Iran</option>
                                <option <?php if ($row['country_of_assemble'] == 'Iraq') echo 'selected'; ?> value="Iraq">Iraq</option>
                                <option <?php if ($row['country_of_assemble'] == 'Ireland') echo 'selected'; ?> value="Ireland">Ireland</option>
                                <option <?php if ($row['country_of_assemble'] == 'Isle of Man') echo 'selected'; ?> value="Isle of Man">Isle of Man</option>
                                <option <?php if ($row['country_of_assemble'] == 'Italy') echo 'selected'; ?> value="Italy">Italy</option>
                                <option <?php if ($row['country_of_assemble'] == 'Jamaica') echo 'selected'; ?> value="Jamaica">Jamaica</option>
                                <option <?php if ($row['country_of_assemble'] == 'Japan') echo 'selected'; ?> value="Japan">Japan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Jordan') echo 'selected'; ?> value="Jordan">Jordan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Kazakhstan') echo 'selected'; ?> value="Kazakhstan">Kazakhstan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Kenya') echo 'selected'; ?> value="Kenya">Kenya</option>
                                <option <?php if ($row['country_of_assemble'] == 'Kiribati">Kiribati</o') echo 'selected'; ?> value="Kiribati">Kiribati</option>
                                <option <?php if ($row['country_of_assemble'] == 'Korea North') echo 'selected'; ?> value="Korea North">Korea North</option>
                                <option <?php if ($row['country_of_assemble'] == 'Korea Sout') echo 'selected'; ?> value="Korea Sout">Korea South</option>
                                <option <?php if ($row['country_of_assemble'] == 'Kuwait') echo 'selected'; ?> value="Kuwait">Kuwait</option>
                                <option <?php if ($row['country_of_assemble'] == 'Kyrgyzstan') echo 'selected'; ?> value="Kyrgyzstan">Kyrgyzstan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Laos') echo 'selected'; ?> value="Laos">Laos</option>
                                <option <?php if ($row['country_of_assemble'] == 'Latvia') echo 'selected'; ?> value="Latvia">Latvia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Lebanon') echo 'selected'; ?> value="Lebanon">Lebanon</option>
                                <option <?php if ($row['country_of_assemble'] == 'Lesotho') echo 'selected'; ?> value="Lesotho">Lesotho</option>
                                <option <?php if ($row['country_of_assemble'] == 'Liberia') echo 'selected'; ?> value="Liberia">Liberia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Libya') echo 'selected'; ?> value="Libya">Libya</option>
                                <option <?php if ($row['country_of_assemble'] == 'Liechtenstein') echo 'selected'; ?> value="Liechtenstein">Liechtenstein</option>
                                <option <?php if ($row['country_of_assemble'] == 'Lithuania') echo 'selected'; ?> value="Lithuania">Lithuania</option>
                                <option <?php if ($row['country_of_assemble'] == 'Luxembourg') echo 'selected'; ?> value="Luxembourg">Luxembourg</option>
                                <option <?php if ($row['country_of_assemble'] == 'Macau') echo 'selected'; ?> value="Macau">Macau</option>
                                <option <?php if ($row['country_of_assemble'] == 'Macedonia') echo 'selected'; ?> value="Macedonia">Macedonia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Madagascar') echo 'selected'; ?> value="Madagascar">Madagascar</option>
                                <option <?php if ($row['country_of_assemble'] == 'Malaysia') echo 'selected'; ?> value="Malaysia">Malaysia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Malawi') echo 'selected'; ?> value="Malawi">Malawi</option>
                                <option <?php if ($row['country_of_assemble'] == 'Maldives') echo 'selected'; ?> value="Maldives">Maldives</option>
                                <option <?php if ($row['country_of_assemble'] == 'Mali') echo 'selected'; ?> value="Mali">Mali</option>
                                <option <?php if ($row['country_of_assemble'] == 'Malta') echo 'selected'; ?> value="Malta">Malta</option>
                                <option <?php if ($row['country_of_assemble'] == 'Marshall Islands') echo 'selected'; ?> value="Marshall Islands">Marshall Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Martinique') echo 'selected'; ?> value="Martinique">Martinique</option>
                                <option <?php if ($row['country_of_assemble'] == 'Mauritania') echo 'selected'; ?> value="Mauritania">Mauritania</option>
                                <option <?php if ($row['country_of_assemble'] == 'Mauritius') echo 'selected'; ?> value="Mauritius">Mauritius</option>
                                <option <?php if ($row['country_of_assemble'] == 'Mayotte') echo 'selected'; ?> value="Mayotte">Mayotte</option>
                                <option <?php if ($row['country_of_assemble'] == 'Mexico') echo 'selected'; ?> value="Mexico">Mexico</option>
                                <option <?php if ($row['country_of_assemble'] == 'Midway Islands') echo 'selected'; ?> value="Midway Islands">Midway Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Moldova') echo 'selected'; ?> value="Moldova">Moldova</option>
                                <option <?php if ($row['country_of_assemble'] == 'Monaco') echo 'selected'; ?> value="Monaco">Monaco</option>
                                <option <?php if ($row['country_of_assemble'] == 'Mongolia') echo 'selected'; ?> value="Mongolia">Mongolia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Montserrat') echo 'selected'; ?> value="Montserrat">Montserrat</option>
                                <option <?php if ($row['country_of_assemble'] == 'Morocco') echo 'selected'; ?> value="Morocco">Morocco</option>
                                <option <?php if ($row['country_of_assemble'] == 'Mozambique') echo 'selected'; ?> value="Mozambique">Mozambique</option>
                                <option <?php if ($row['country_of_assemble'] == 'Myanmar') echo 'selected'; ?> value="Myanmar">Myanmar</option>
                                <option <?php if ($row['country_of_assemble'] == 'Nambia') echo 'selected'; ?> value="Nambia">Nambia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Nauru') echo 'selected'; ?> value="Nauru">Nauru</option>
                                <option <?php if ($row['country_of_assemble'] == 'Nepal') echo 'selected'; ?> value="Nepal">Nepal</option>
                                <option <?php if ($row['country_of_assemble'] == 'Netherland Antilles') echo 'selected'; ?> value="Netherland Antilles">Netherland Antilles</option>
                                <option <?php if ($row['country_of_assemble'] == 'Netherlands') echo 'selected'; ?> value="Netherlands">Netherlands (Holland, Europe)</option>
                                <option <?php if ($row['country_of_assemble'] == 'Nevis') echo 'selected'; ?> value="Nevis">Nevis</option>
                                <option <?php if ($row['country_of_assemble'] == 'New Caledonia') echo 'selected'; ?> value="New Caledonia">New Caledonia</option>
                                <option <?php if ($row['country_of_assemble'] == 'New Zealand') echo 'selected'; ?> value="New Zealand">New Zealand</option>
                                <option <?php if ($row['country_of_assemble'] == 'Nicaragua') echo 'selected'; ?> value="Nicaragua">Nicaragua</option>
                                <option <?php if ($row['country_of_assemble'] == 'Niger') echo 'selected'; ?> value="Niger">Niger</option>
                                <option <?php if ($row['country_of_assemble'] == 'Nigeria') echo 'selected'; ?> value="Nigeria">Nigeria</option>
                                <option <?php if ($row['country_of_assemble'] == 'Niue') echo 'selected'; ?> value="Niue">Niue</option>
                                <option <?php if ($row['country_of_assemble'] == 'Norfolk Island') echo 'selected'; ?> value="Norfolk Island">Norfolk Island</option>
                                <option <?php if ($row['country_of_assemble'] == 'Norway') echo 'selected'; ?> value="Norway">Norway</option>
                                <option <?php if ($row['country_of_assemble'] == 'Oman') echo 'selected'; ?> value="Oman">Oman</option>
                                <option <?php if ($row['country_of_assemble'] == 'Pakistan') echo 'selected'; ?> value="Pakistan">Pakistan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Palau Island">Palau I') echo 'selected'; ?> value="Palau Island">Palau Island</option>
                                <option <?php if ($row['country_of_assemble'] == 'Palestine') echo 'selected'; ?> value="Palestine">Palestine</option>
                                <option <?php if ($row['country_of_assemble'] == 'Panama') echo 'selected'; ?> value="Panama">Panama</option>
                                <option <?php if ($row['country_of_assemble'] == 'Papua New Guinea') echo 'selected'; ?> value="Papua New Guinea">Papua New Guinea</option>
                                <option <?php if ($row['country_of_assemble'] == 'Paraguay') echo 'selected'; ?> value="Paraguay">Paraguay</option>
                                <option <?php if ($row['country_of_assemble'] == 'Peru') echo 'selected'; ?> value="Peru">Peru</option>
                                <option <?php if ($row['country_of_assemble'] == 'Phillipines') echo 'selected'; ?> value="Phillipines">Philippines</option>
                                <option <?php if ($row['country_of_assemble'] == 'Pitcairn Island') echo 'selected'; ?> value="Pitcairn Island">Pitcairn Island</option>
                                <option <?php if ($row['country_of_assemble'] == 'Poland') echo 'selected'; ?> value="Poland">Poland</option>
                                <option <?php if ($row['country_of_assemble'] == 'Portugal') echo 'selected'; ?> value="Portugal">Portugal</option>
                                <option <?php if ($row['country_of_assemble'] == 'Puerto Rico') echo 'selected'; ?> value="Puerto Rico">Puerto Rico</option>
                                <option <?php if ($row['country_of_assemble'] == 'Qatar') echo 'selected'; ?> value="Qatar">Qatar</option>
                                <option <?php if ($row['country_of_assemble'] == 'Republic of Montenegr') echo 'selected'; ?> value="Republic of Montenegro">Republic of Montenegro</option>
                                <option <?php if ($row['country_of_assemble'] == 'Republic of Serbia') echo 'selected'; ?> value="Republic of Serbia">Republic of Serbia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Reunion') echo 'selected'; ?> value="Reunion">Reunion</option>
                                <option <?php if ($row['country_of_assemble'] == 'Romania') echo 'selected'; ?> value="Romania">Romania</option>
                                <option <?php if ($row['country_of_assemble'] == 'Russia') echo 'selected'; ?> value="Russia">Russia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Rwanda') echo 'selected'; ?> value="Rwanda">Rwanda</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Barthelemy') echo 'selected'; ?> value="St Barthelemy">St Barthelemy</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Eustatius') echo 'selected'; ?> value="St Eustatius">St Eustatius</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Helena') echo 'selected'; ?> value="St Helena">St Helena</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Kitts-Nevis') echo 'selected'; ?> value="St Kitts-Nevis">St Kitts-Nevis</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Lucia') echo 'selected'; ?> value="St Lucia">St Lucia</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Maarten') echo 'selected'; ?> value="St Maarten">St Maarten</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Pierre & Miquelon') echo 'selected'; ?> value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                <option <?php if ($row['country_of_assemble'] == 'St Vincent & Grenadin') echo 'selected'; ?> value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                <option <?php if ($row['country_of_assemble'] == 'Saipan') echo 'selected'; ?> value="Saipan">Saipan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Samoa') echo 'selected'; ?> value="Samoa">Samoa</option>
                                <option <?php if ($row['country_of_assemble'] == 'Samoa American') echo 'selected'; ?> value="Samoa American">Samoa American</option>
                                <option <?php if ($row['country_of_assemble'] == 'San Marino') echo 'selected'; ?> value="San Marino">San Marino</option>
                                <option <?php if ($row['country_of_assemble'] == 'Sao Tome & Principe') echo 'selected'; ?> value="Sao Tome & Principe">Sao Tome & Principe</option>
                                <option <?php if ($row['country_of_assemble'] == 'Saudi Arabia') echo 'selected'; ?> value="Saudi Arabia">Saudi Arabia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Senegal') echo 'selected'; ?> value="Senegal">Senegal</option>
                                <option <?php if ($row['country_of_assemble'] == 'Seychelles') echo 'selected'; ?> value="Seychelles">Seychelles</option>
                                <option <?php if ($row['country_of_assemble'] == 'Sierra Leone') echo 'selected'; ?> value="Sierra Leone">Sierra Leone</option>
                                <option <?php if ($row['country_of_assemble'] == 'Singapore') echo 'selected'; ?> value="Singapore">Singapore</option>
                                <option <?php if ($row['country_of_assemble'] == 'Slovakia') echo 'selected'; ?> value="Slovakia">Slovakia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Slovenia') echo 'selected'; ?> value="Slovenia">Slovenia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Solomon Islands') echo 'selected'; ?> value="Solomon Islands">Solomon Islands</option>
                                <option <?php if ($row['country_of_assemble'] == 'Somalia') echo 'selected'; ?> value="Somalia">Somalia</option>
                                <option <?php if ($row['country_of_assemble'] == 'South Africa') echo 'selected'; ?> value="South Africa">South Africa</option>
                                <option <?php if ($row['country_of_assemble'] == 'Spain') echo 'selected'; ?> value="Spain">Spain</option>
                                <option <?php if ($row['country_of_assemble'] == 'Sri Lanka') echo 'selected'; ?> value="Sri Lanka">Sri Lanka</option>
                                <option <?php if ($row['country_of_assemble'] == 'Sudan') echo 'selected'; ?> value="Sudan">Sudan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Suriname') echo 'selected'; ?> value="Suriname">Suriname</option>
                                <option <?php if ($row['country_of_assemble'] == 'Swaziland') echo 'selected'; ?> value="Swaziland">Swaziland</option>
                                <option <?php if ($row['country_of_assemble'] == 'Sweden') echo 'selected'; ?> value="Sweden">Sweden</option>
                                <option <?php if ($row['country_of_assemble'] == 'Switzerland') echo 'selected'; ?> value="Switzerland">Switzerland</option>
                                <option <?php if ($row['country_of_assemble'] == 'Syria') echo 'selected'; ?> value="Syria">Syria</option>
                                <option <?php if ($row['country_of_assemble'] == 'Tahiti') echo 'selected'; ?> value="Tahiti">Tahiti</option>
                                <option <?php if ($row['country_of_assemble'] == 'Taiwan') echo 'selected'; ?> value="Taiwan">Taiwan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Tajikistan') echo 'selected'; ?> value="Tajikistan">Tajikistan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Tanzania') echo 'selected'; ?> value="Tanzania">Tanzania</option>
                                <option <?php if ($row['country_of_assemble'] == 'Thailand') echo 'selected'; ?> value="Thailand">Thailand</option>
                                <option <?php if ($row['country_of_assemble'] == 'Togo') echo 'selected'; ?> value="Togo">Togo</option>
                                <option <?php if ($row['country_of_assemble'] == 'Tokelau') echo 'selected'; ?> value="Tokelau">Tokelau</option>
                                <option <?php if ($row['country_of_assemble'] == 'Tonga') echo 'selected'; ?> value="Tonga">Tonga</option>
                                <option <?php if ($row['country_of_assemble'] == 'Trinidad & Tobago') echo 'selected'; ?> value="Trinidad & Tobago">Trinidad & Tobago</option>
                                <option <?php if ($row['country_of_assemble'] == 'Tunisia') echo 'selected'; ?> value="Tunisia">Tunisia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Turkey') echo 'selected'; ?> value="Turkey">Turkey</option>
                                <option <?php if ($row['country_of_assemble'] == 'Turkmenistan') echo 'selected'; ?> value="Turkmenistan">Turkmenistan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Turks & Caicos Is') echo 'selected'; ?> value="Turks & Caicos Is">Turks & Caicos Is</option>
                                <option <?php if ($row['country_of_assemble'] == 'Tuvalu') echo 'selected'; ?> value="Tuvalu">Tuvalu</option>
                                <option <?php if ($row['country_of_assemble'] == 'Uganda') echo 'selected'; ?> value="Uganda">Uganda</option>
                                <option <?php if ($row['country_of_assemble'] == 'United Kingdom') echo 'selected'; ?> value="United Kingdom">United Kingdom</option>
                                <option <?php if ($row['country_of_assemble'] == 'Ukraine') echo 'selected'; ?> value="Ukraine">Ukraine</option>
                                <option <?php if ($row['country_of_assemble'] == 'United Arab Erimates') echo 'selected'; ?> value="United Arab Erimates">United Arab Emirates</option>
                                <option <?php if ($row['country_of_assemble'] == 'United States of Amer') echo 'selected'; ?> value="United States of America">United States of America</option>
                                <option <?php if ($row['country_of_assemble'] == 'Uraguay') echo 'selected'; ?> value="Uraguay">Uruguay</option>
                                <option <?php if ($row['country_of_assemble'] == 'Uzbekistan') echo 'selected'; ?> value="Uzbekistan">Uzbekistan</option>
                                <option <?php if ($row['country_of_assemble'] == 'Vanuatu') echo 'selected'; ?> value="Vanuatu">Vanuatu</option>
                                <option <?php if ($row['country_of_assemble'] == 'Vatican City State') echo 'selected'; ?> value="Vatican City State">Vatican City State</option>
                                <option <?php if ($row['country_of_assemble'] == 'Venezuela') echo 'selected'; ?> value="Venezuela">Venezuela</option>
                                <option <?php if ($row['country_of_assemble'] == 'Vietnam') echo 'selected'; ?> value="Vietnam">Vietnam</option>
                                <option <?php if ($row['country_of_assemble'] == 'Virgin Islands (Brit)') echo 'selected'; ?> value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                <option <?php if ($row['country_of_assemble'] == 'Virgin Islands (USA)') echo 'selected'; ?> value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                <option <?php if ($row['country_of_assemble'] == 'Wake Island">Wake Isl') echo 'selected'; ?> value="Wake Island">Wake Island</option>
                                <option <?php if ($row['country_of_assemble'] == 'Wallis & Futana Is') echo 'selected'; ?> value="Wallis & Futana Is">Wallis & Futana Is</option>
                                <option <?php if ($row['country_of_assemble'] == 'Yemen') echo 'selected'; ?> value="Yemen">Yemen</option>
                                <option <?php if ($row['country_of_assemble'] == 'Zaire') echo 'selected'; ?> value="Zaire">Zaire</option>
                                <option <?php if ($row['country_of_assemble'] == 'Zambia') echo 'selected'; ?> value="Zambia">Zambia</option>
                                <option <?php if ($row['country_of_assemble'] == 'Zimbabwe') echo 'selected'; ?> value="Zimbabwe">Zimbabwe</option>
                            </select>

                        </div>
                        <label class="col-sm-2 col-form-label"> Brand Name</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" name="brand_name" value="<?php echo $row['brand_name']; ?>" class="form-control" placeholder="Enter Brand Name" id="memid">
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <label class="col-sm-2 col-form-label">Model Name</label>
                        <label class="col-form-label">:</label>
                        <div class="col">
                            <input type="text" name="model_name" value="<?php echo $row['model_name']; ?>" placeholder="Enter Model Name" class="form-control" id="memid">
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <label class="col-form-label"></label>
                        <div class="col">
                            <!-- <input type="text" class="form-control" readonly> -->
                        </div>
                    </div>

                    <td>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary pull-right"> Update Item</button>
                        </div>
                    </td>
                </form>
            </div>
            <!-- ----------------code here---------------->
        </div>
        <?php
        if (!empty($message)) {
            echo '<script type="text/javascript">
                Swal.fire(
                    "Save Successfully!!",
                    "Welcome ' . $_SESSION['username'] . '",
                    "success"
                  )
                </script>';
        } else {
        }
        if (!empty($message_failled)) {
            echo '<script type="text/javascript">
                Swal.fire(
                    "Failled !!",
                    "Welcome ' . $_SESSION['username'] . '",
                    "success"
                  )
                </script>';
        } else {
        }
        ?>
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
<script src="../js/select2.full.min.js"></script>
<script src="../js/bootstrap.min"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $("#accinfo").addClass('active');
        $("#gl_acc").addClass('active');
        $("#accinfo").addClass('is-expanded');
    });
</script>
<?php
//$conn->close();
?>
</body>

</html>