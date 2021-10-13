<?php 
//session_name('ma_session');
//session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Communes de la MEL</title>
    <link rel="stylesheet" type="text/css" href="css/style_td6.css" />

    <script src="js/carte.js"></script>
    <script src="js/fetchUtils.js"></script>
    <script src="js/communes.js"></script>
    <script src="js/login.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

</head>

<body>
    <header>
        <h1>Communes de la MEL</h1>

        <div id="head">
            <h2>Authentifiez-vous</h2>
            <form id="form_login" method="POST" action="">
                <label for="login">Login :</label>
                <input type="text" name="login" id="login" required="required" autofocus />
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required="required" />
                <button type="submit" name="valid">OK</button>
            </form>
            <p>Pas encore inscrit ? <a href="register.php">créez un compte.</a></p>
        </div>

        <p id="text"></p>
        <div id="out" style="display:none;"><button id="logout">Se déconnecter</button></div>

    </header>
    <section id="main">
        <div id="choix">
            <form id="form_communes" action="">
                <fieldset>
                    <legend>Choix des communes</legend>
                    <label>Territoire :
                        <select name="territoire">
                            <option value="" data-min_lat="50.499" data-min_lon="2.789" data-max_lat="50.794" data-max_lon="3.272">
                                Tous
                            </option>
                        </select>
                    </label>
                    <label>Nom : <br><input type="text" name="nom" placeholder="el" autofocus><br></label>
                    <label>Surface Minimum : <input type="text" name="surface_min" placeholder="10.5"></label>
                    <label>Population Minimum : <input type="text" name="pop_totale" placeholder="2000"></label>
                    <label>Recensement : <input type="text" name="recensement" placeholder="obligatoire (ex:2016)" value="2016" id="recensement"></label>
                </fieldset>

                <button type="submit" id="submit">Afficher la liste</button>
                <button type="reset">Reset</button>

            </form>
        </div>
        <div id='carte'></div>
        <ul id="liste_communes">
        </ul>

        <div id="details"></div>
        <div id="details1"></div>
    </section>

    <footer>
    </footer>
</body>

</html>
<script>
    var recensement = document.forms["form_communes"]["recensement"];
    var accept = document.getElementById("submit");
    recensement.addEventListener('input', validation);

    function validation() {
        if (recensement.value != "") {
            accept.disabled = false;
        } else {
            accept.disabled = true;
        }
    }
</script>