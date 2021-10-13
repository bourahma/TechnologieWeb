<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try {
   $login    = checkString('login');
   $password = checkString('password');
   
   $res = $data->authentification($login, $password);
    
   if(isset($_SESSION['ident'])){
       produceError("Déjà connecté");
   }
   else{
       //session_name('ma_session');
       //session_start();
       $_SESSION['ident'] = $res;
       produceResult($res);
   }
} 
catch (ParmsException $e) {
   produceError("Erreur, les paramètres sont manquants  !");
}   
catch (PDOException $e) {
   produceError("Erreur, les paramètres sont incorrects !");
}   
?>