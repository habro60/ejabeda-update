<?php
    if (isset($_POST['enter'])) {
      require '../database.php';

      if(isset($_FILES['profiler'])){
        $profileImageName = time().'_'.$_FILES['profiler']['name'];
        $profileImageTempLoc = $_FILES['profiler']['tmp_name'];
        $target = '../images/org_img/' . $profileImageName;

        move_uploaded_file($profileImageTempLoc, $target);
      }
      
      $name = $_POST['name'];
      $slogan = $_POST['slogan'];
      $address1 = $_POST['address1'];
      $address2 = $_POST['address2'];
      $email = $_POST['email'];
      $telephone = $_POST['telephone'];
      $fax = $_POST['fax'];
      $website = $_POST['website'];
      $country = $_POST['country'];
      $fmStart = $_POST['fmStart'];
      $fyStart = $_POST['fyStart'];
      $fmEnd = $_POST['fmEnd'];
      $fyEnd = $_POST['fyEnd'];
      $budget = $_POST['budget'];
      $noOfDec = $_POST['noOfDec'];
      $locCurr = $_POST['locCurr'];
      $locCurrSym = $_POST['locCurrSym'];
      $forCurr = $_POST['forCurr'];
      $forCurrSym = $_POST['forCurrSym'];
      $inventory = $_POST['inventory'];
      $round = $_POST['round'];
      $imgType = $_POST['imgType'];
      $imgPath = $_POST['imgPath'];
      $roundType = $_POST['roundType'];

      // echo $imgType . "</br>" . $roundType;

      $sql = "INSERT INTO org_info (ORG_NAME,ORG_ADDR1,ORG_ADDR2,ORG_EMAIL,ORG_WEBSITE,ORG_FAX,ORG_TEL,ORG_COUNTRY,ORG_SLORGAN,ORG_LOGO,ORG_FIN_MONTH,ORG_FIN_YEAR_ST,ORG_BUDGET_YEAR,ORG_MAINTAIN_INV,ORG_EMP_IMG_TYPE,ORG_PATH_EMP_IMG,ORG_LOC_CURR_NAME,ORG_LOC_CURR_SYMBOL,ORG_FOR_CURR_NAME,ORG_FOR_CURR_SYMBOL,ORG_NO_OF_DECIMAL,ORG_ROUNDING_DECI,ORG_ROUNDING_TYPE,ORG_EOM_DATE,ORG_EOY_DATE) VALUES(".
        "'$name',".
        "'$address1',".
        "'$address2',".
        "'$email',".
        "'$website',".
        "'$fax',".
        "'$telephone',".
        "'$country',".
        "'$slogan',".
        "'$profileImageName',".
        "'$fmStart',".
        "'$fyStart',".
        "'$budget',".
        "'$inventory',".
        "'$imgType',".
        "'$imgPath',".
        "'$locCurr',".
        "'$locCurrSym',".
        "'$forCurr',".
        "'$forCurrSym',".
        "'$noOfDec',".
        "'$round',".
        "'$roundType',".
        "'$fmEnd',".
        "'$fyEnd')";
        echo $sql;  
      $conn->query($sql);
      if($conn->affected_rows == 1){
        echo "Success";
      }
      else{
        echo "Failed";
      }  
      $conn->close();
      // header("location:post_process.php");
  }
?>