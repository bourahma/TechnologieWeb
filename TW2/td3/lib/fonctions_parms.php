<?php
 require(__DIR__."/color_defs.php"); // definit la constante COLOR_KEYWORDS

 /**
  *  prend en compte le paramètre $name passé en mode GET
  *   qui doit représenter une couleur CSS
  *  @return : valeur retenue
  *   - si le paramètre est absent ou vide, renvoie  $defaultValue
  *   - si le paramètre est incorrect, déclenche une exception ParmsException
  *
  */
 function checkColor(string $name, string $defaultValue) : string {
   if (!isset($_GET[$name]) || ($_GET[$name] === "")) {
     $color = $defaultValue;
   } elseif (array_key_exists($_GET[$name], COLOR_KEYWORDS) || $_GET[$name] === 'transparent') {
     $color = $_GET[$name];
   } elseif ((preg_match(COLOR_REGEXP, $_GET[$name]) === 1 ) && in_array($_GET[$name], COLOR_KEYWORDS)) {
     $color = $_GET[$name];
   } else {
     throw new ParmsException("Error Processing Request");
   }
   return $color;
 }

 /**
  *  prend en compte le paramètre $name passé en mode GET
  *   qui doit représenter un entier sans signe
  *  @return : valeur retenue, convertie en int.
  *   - si le paramètre est absent ou vide, renvoie  $defaultValue
  *   - si le paramètre est incorrect, déclenche une exception ParmsException
  *
  */
 function checkUnsignedInt(string $name, int $defaultValue) : int {

   if (!isset($_GET[$name]) || ($_GET[$name] === "")) {
     $_GET[$name] = $defaultValue;
   } elseif (!ctype_digit($_GET[$name])) {
     throw new ParmsException("Error Processing Request");
   }
   return $_GET[$name];
  }

?>
