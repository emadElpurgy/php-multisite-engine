<?php
require_once "common/dSendMail2.inc.php";
$m = new dSendMail2;
$m->setTo("egyption_reseller@yahoo.com");
$m->setSubject("My sample subject");
$m->setMessage("My sample message");
// Put your e-mail address and uncomment the server you wish to try!
$m->setFrom("emad_elpurgy@yahoo.com");
#$m->sendThroughGMail  ("uemad_elpurgy@yahoo.com",   "0122534157");
$m->sendThroughYahoo  ("emad_elpurgy@yahoo.com",   "0122534157");
# $m->sendThroughHotMail("username@hotmail.com", "password");
$m->debug = true;
$m->send();
