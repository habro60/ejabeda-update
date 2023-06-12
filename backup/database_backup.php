<?php

session_start();

require "../database.php";

if ($_SESSION["org_no"]) {
    
    $sql= mysqli_query($conn,"SELECT DATABASE()");
    $row = mysqli_fetch_assoc($sql);
    $db= $row['DATABASE()'];
}else {
    echo "no";
}

   require('Mysqldump.php');

   

    //$db=$_SESSION['db'];

    $dump = new Ifsnop\Mysqldump\Mysqldump("mysql:host=localhost;dbname=$db", 'root', '');
    $date = date('Y-m-d');
    $rand = rand(10000, 99999);

    // if (isset($_SESSION['db'])) {
    //     echo $_SESSION['db'];
    // }else {
    //     echo "no db found";
    // }

    // die;

    //$dump->start('storage/'.$date.-$rand.'$date.sql');
    $dump->start("storage/$rand.$date.sql");
    
 require('smtp/PHPMailerAutoload.php');
 //require ('smtp/class.phpmailer.php');
  require ('smtp/class.smtp.php');
 // require('smtp/get_oauth_token.php');
 
//  function send()
//     {
//         try {
//             if (!$this->preSend()) {
//                 return false;
//             }
//             return $this->postSend();
//         } catch (phpmailerException $exc) {
//             $this->mailHeader = '';
//             $this->setError($exc->getMessage());
//             if ($this->exceptions) {
//                 throw $exc;
//             }
//             return false;
//         }
//     }
 
   
    $mail=new PHPMailer(true);
    $mail->SMTPDebug  = 3;
    $mail->isSMTP();
    $mail->Host="smtp.gmail.com";
    $mail->Port=587;
    $mail->SMTPSecure="tls";
    $mail->SMTPAuth=true;
    $mail->Username="habrosystemltd@gmail.com";
    $mail->Password="Habro123456@";
    $mail->SetFrom("habrosystemltd@gmail.com");
    $mail->addAddress('habrosystemltd@gmail.com'); 
    $mail->IsHTML(true);
    $mail->Subject="Website Backup ".$date;
    $mail->Body="Website Backup";
    $mail->AddAttachment("storage/$rand.$date.sql");
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    if($mail->send()){
        echo "Database Backup Successfully Done.Please check your email";
    }else{
        echo "Error occur";
    }  