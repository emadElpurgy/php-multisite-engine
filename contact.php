<?
header("Cache-Control: no-cache, must-revalidate");
$db_hostname='localhost';
$db_database='emad';
$db_username='root';
$db_password='9272';
$db_server=mysql_connect($db_hostname,$db_username,$db_password);
mysql_query("SET NAMES UTF8");
mysql_query("set characer set UTF8",$db_server);
if(!$db_server)die($error[10001].mysql_error());
mysql_select_db($db_database)or die ($error[10002].mysql_error());
$insertQuery = 'insert into `messages`(`sender_name`,`sender_email`,`subject`,`message`)values("'.addslashes($_POST['name']).'","'.$_POST['email'].'","'.$_POST['subject'].'","'.$_POST['message'].'")';
$insertResult = mysql_query($insertQuery);
?>