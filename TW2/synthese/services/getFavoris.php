<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try{
  //$_SESSION['ident'];
  $result = $data->getCommunesWithConds($territoire, $nom, $surface_min*10000, $pop_totale, $recensement);
  
  produceResult($result);
}
catch (PDOException $e){
    produceError($e->getMessage());
}
?>