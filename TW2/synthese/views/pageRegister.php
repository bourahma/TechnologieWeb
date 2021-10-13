<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Création d'utilisateur</title>
    <script src="js/fetchUtils.js"></script>
    <script src="js/register.js"></script>

<style>
    h2,
    p {
        text-align: center;
    }

    fieldset {
        background-color: #CCC;
        max-width: 1000px;
        padding: 16px;
        margin: auto;
    }
</style>
</head>
<body>
    <h2>Demande de création d'un utilisateur</h2>

    <?php
//if (isset($erreurCreation) && $erreurCreation)
//   echo "<p class='message'>Le compte n'a pas pu être créé</p>";
?>

    <form method="POST" id="form_register" action="">
        <fieldset>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required="required" autofocus />
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required="required" autofocus />
            <label for="login">Login :</label>
            <input type="text" name="login" id="login" required="required" autofocus />
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required="required" />
            <button type="submit" name="valid" value="bouton_valid">OK</button>
        </fieldset>
    </form>
    <p id="text"></p>
    <p>
    <a href="index.php">Retour à la page principale</a>
    </p>
</body>

</html>
