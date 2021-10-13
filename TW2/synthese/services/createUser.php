<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try {
   $login    = checkStringPOST('login');
   $password = checkStringPOST('password');
   $nom      = checkStringPOST('nom');
   $prenom   = checkStringPOST('prenom');
   
   $res = $data->createUser($login, $password, $nom, $prenom);

   produceResult($res);
 } 
catch (ParmsException $e) {
   produceError("Erreur, les paramètres sont manquants ou incorrects !");
}
catch (PDOException $e){
   produceError("Erreur, ce login existe déjà !");
}  
?>