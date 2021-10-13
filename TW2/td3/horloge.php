<?php

  require("lib/ParmsException.class.php");
  require("lib/fonctions_parms.php");
  require("lib/fonctions_clock.php");

/**
 * IMPORTANT :
 * Ce script n'est qu'une ébauche.
 *
 * En l'état actuel son fonctionnement n'est pas satisfaisant
 *
 *
 * Utiliser directement les variable du tableau $_GET peut être dangereux
 *
 * Ce script est à modifier et compléter au cours de l'exercice
 *
 */


  try{
   // hours doit être un entier sans signe
   $hours = checkUnsignedInt('hours', 0);

   // coleur doit être une chaîne.
   $hands = checkColor('hands', 'red');

   // couleur des markers.
   $markers = checkColor('markers', 'grey');

   // couleur du fond de l'horloge.
   $bg = checkColor('bg', 'transparent');

   // minutes doit être un entier sans signe
   $minutes = checkUnsignedInt('minutes', 0);

   // seconds doit être un entier sans signe
   $seconds = checkUnsignedInt('seconds', 0);

   // calcul des angles des aiguilles
   $angles = angles($hours, $minutes, $seconds);

   // inclusion de la page template :
   require('views/page.php');

  } catch (ParmsException $e){
    require('views/pageErreur.html');
  }




?>
