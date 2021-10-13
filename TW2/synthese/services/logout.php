<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try {    
   if(!isset($_SESSION['ident'])){
       produceError("L’utilisateur n’était pas connecté");
   }
   else{
       $personne = $_SESSION['ident'];
       unset($_SESSION['ident']);
       session_destroy();
       produceResult($personne->login);   
       
   }
 } 

catch (ParmsException $e) {
   produceError("Erreur, les paramètres sont manquants ou incorrects !");
}
?>
