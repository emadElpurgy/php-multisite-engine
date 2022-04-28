<?php

// database connection & data insert above

//email registeration confirmation
/*
$mysite = "mayor shipping";
$webmaster = "Webmaster @ mayor shipping";
$myemail = $webmaster." info@mayorshipping.com";

$subject = "Weekly Sports Updates from $mysite";
$message = "this is message";


$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: SC SPORTS <info@mayorshipping.com>' . "\r\n";
$headers .= 'To: SC SPORTS <elpurgy@egcan.com>' . "\r\n";
mail("elpurgy@egcan.com", $subject, $message, $headers)or die("error");
echo "A confirmation has been sent to your email address.";
*/

/*
require_once "mail/dSendMail2.inc.php";
$m = new dSendMail2;
$m->setTo("emad_elpurgy@hotmail.com");
$m->setSubject("Mayor - Track a shippment");
$message=$html;
$m->setMessage($message,true,true);
$m->setFrom("info@mayorshipping.com");
echo $m->sendThroughGMail("info@mayorshipping.com",   "info17");
//echo $m->sendThroughMail();
//$m->sendThroughYahoo("emad_elpurgy@yahoo.com",   "purgyPass@201655");
$m->debug = true;
$m->send();
echo 'done';
*/
require_once "mail/src/PHPMailer.php";
$mail = new PHPMailer();  // create a new object
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = "localhost";
$mail->Port = "25";
$mail->SMTPSecure = "none";
$mail->SMTPAuth = false;
$mail->Username = "info@mayorshipping.com";
$mail->Password = "info17";
    $mail->SetFrom("info@mayorshipping.com", "webmaster");
    $mail->Subject = "contaner information";
    $mail->Body = "this is the information of the contaner";
    $mail->AddAddress("emad_elpurgy@hotmail.com");
    if(!$mail->Send()) {
        $error = 'Mail error: '.$mail->ErrorInfo;
        return false;
    } else {
        $error = 'Message sent!';
        return true;
    }
/************************** end of php errors ***************************/
?>