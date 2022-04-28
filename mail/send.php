<?php
require_once "mail/class.phpmailer.php";
$mail = new PHPMailer();  // create a new object
echo '</br>object 1 created';
$mail->isSMTP();
echo '</br>object 2 created';
$mail->SMTPDebug = 1;
$mail->Host = "smtpout.secureserver.net";
$mail->Port = "80";
$mail->SMTPSecure = "none";
$mail->SMTPAuth = true;
//$mail->SMTPSecure   = "ssl";
$mail->Username = "info@mayorshipping.com";
$mail->Password = "info17";
    $mail->SetFrom("info@mayorshipping.com", "Mayor Shipping Webmaster");
echo '<br>from has been set';
    $mail->Subject = "Mayor World Shipping - Track a shippment";
echo '<br>subject has been set';
    $mail->IsHTML(true);
    $mail->Body = $html;
echo '<br>body has been set';
    $mail->AddAddress($_GET['Remail']);
echo '<br>address has been set';
    if(!$mail->Send()) {
        $error = 'Mail error: '.$mail->ErrorInfo;
echo '<br>'.$error;
    } else {
        $error = 'Message sent!';
echo '<br>'.$error;
    }
echo '</br>all done';
/************************** end of php errors ***************************/
?>