<?php
spl_autoload_register(function ($className) {
     include ("lib/{$className}.class.php");
 });

try {
  require('lib/initDataLayer.php');
  require('lib/fonctions_parms.php');
  
   $login    = checkUnsignedStr('login',NULL,FALSE);
   $password = checkUnsignedStr('password',NULL,FALSE);
   $nom      = checkUnsignedStr('nom',NULL,FALSE);
   $prenom   = checkUnsignedStr('prenom',NULL,FALSE);
   
   $res = $data->createUser($login, $password, $nom, $prenom);
   if ($res){
     require('views/pageCreateOK.php');
     exit();
   } else {
     $erreurCreation = true;
     require('views/pageRegister.php');
     exit();
   }
 } catch (ParmsException $e) {
   echo $e;
 }

?>
