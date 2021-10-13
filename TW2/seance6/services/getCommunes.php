<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try{
  $territoire = checkUnsignedInt('territoire',NULL,FALSE);
    
  $result = $data->getCommunes($territoire);
    
  produceResult($result);
}
catch (PDOException $e){
    produceError($e->getMessage());
}


?>
