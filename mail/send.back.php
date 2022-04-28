<?
$to      = $_GET['Remail'];
$subject = 'Mayor - Track a shippment';
$message = $message;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Additional headers
$headers .= 'To: '.$_GET['Rname'].' <'.$_GET['Remail'].'>' . "\r\n";
$headers .= 'From: '.$_GET['Uname'].' <m.kenany@mayorworldshipping.com>' . "\r\n";

mail($to, $subject, 'this messeage was send to emad elpurgy', $headers)or die("error");
echo '</br>Message Sent.';
exit();
?>