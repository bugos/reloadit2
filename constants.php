<?php
/*--Constants--*/
define('API', 'http://whatsup.ogilvy.phaistosnetworks.gr/api');
//define('API', ''); //debug
define('LOG_FILE', 'FILES/reloadit.log');
define('TRICK_FILE', 'FILES/trick.json');
define('INDEX_FILE', $_SERVER['PHP_SELF']);
//define('SUBMIT_FILE', 'index.php');

/*--Variables--*/
$phone = isset_shield($_COOKIE['phone']);
$code  = isset_shield($_COOKIE['code']);
$prizeid = isset_shield($_GET['prizeid']);
?>