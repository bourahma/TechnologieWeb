<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try{
  $territoire    = checkUnsignedInt('territoire',NULL,FALSE);
  $nom           = checkString('nom',NULL,FALSE);
  $surface_min   = checkString('surface_min',NULL,FALSE);
  $pop_totale    = checkUnsignedInt('pop_totale',NULL,FALSE);
  $recensement   = checkUnsignedInt('recensement',NULL,FALSE);
  
    
  $result = $data->getCommunesWithConds($territoire, $nom, $surface_min*10000, $pop_totale, $recensement);
  
  produceResult($result);
}
catch (PDOException $e){
    produceError($e->getMessage());
}
?>