<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try{
  $insee = checkString('insee');
    
  $result = $data->getDetails($insee);
    
  if($result != null){
      produceResult($result);
  } else {
      produceError("Il n'y a pas des données");
  }
}
catch (PDOException $e){
    produceError($e->getMessage());
}


?>
