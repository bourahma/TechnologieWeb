<?php
spl_autoload_register(function ($className) {
     include ("lib/{$className}.class.php");
 });
require('lib/initDataLayer.php');

require_once('lib/watchdog.php'); 

require('views/pageErreur.php');
?>
