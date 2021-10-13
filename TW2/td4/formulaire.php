<?php
    spl_autoload_register(function($classe){require "lib/$classe.class.php";}); // règle de chargement des classes
    require("etc/dsn_filename.php"); // definition de DSN_FILENAME

    require("lib/fonctionsLivre.php");
    try {
        $dl = new DataLayer(DSN_FILENAME);
        $auteurs = $dl->getAuthors();
        $annees = $dl->getYears();
        $category = $dl->getCategory();

        $optionsAuteurs = authorsArrayToOptions($auteurs);
        $optionsYears = yearsArrayToOptions($annees);
        $optionsCategory = categoryArrayToOptions($category);
        
        require("views/pageFormulaire.php"); // pour la question 1

    } catch (ParmsException $e) {
        require "views/pageErreur.php";
    }
?>
