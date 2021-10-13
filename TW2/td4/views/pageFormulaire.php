<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Formulaire de recherche de livres</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="css/style_page_formulaire.css" />
        <style>

        </style>
    </head>
    <body>
        <header>
            <h1>Formulaire de recherche de livres</h1>
        </header>

       <form action="bib_search.php" method="get">
        <label>Choix de l'auteur :
            <select name="author_id">
                <option value="">(tous)</option>
                <?= $optionsAuteurs ?>
            </select> <br />
        </label>

        <label>Choix de l'année :
            <select name="year">
                <option value="">(tous)</option>
                <?= $optionsYears?>
            </select> <br/>
        </label>

        <label>Choix de la categorie :
            <select name="categorie">
                <option value="">(tous)</option>
                <?= $optionsCategory?>
            </select> <br/>
        </label>

        <label>Mot clé :
            <input name="titre" placeholder="Dune" type="text" size="20" maxlength="30"/>  <br/>
        </label>

        <button type="submit" name="valid" value="1">Rechercher</button>
       </form>

    </body>

</html>
