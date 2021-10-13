<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Premier exercice PHP</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="iniPHP.css" />
    </head>
    <body>
        <header>
            <h1>Premier exercice PHP</h1>
            <h2>Réalisé par <span class="nom">Aziz BOURAHMA</span></h2>
        </header>
        <!-- section résultat. Créer une section pour chaque question -->
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p>Nous sommes le <?= date('d / m / Y') ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= afficheVar(59650, "University of Lille") ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= n_parag("University of Lille", 5) ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= diminue("University of Lille") ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= diminue_v2("University of Lille") ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= tableMultiplication(5) ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= tablesMultiplications() ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= tableauMult() ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= enP("Et qu'on sorte+  Vistement : +Car Clément + Le vous mande.    ") ?></p>
        </section>
        <section>
            <h2>Question <?= $num_quest++ ?></h2>
            <p><?= enSpan("    Dupont - Durand      ") ?></p>
        </section>
    </body>

</html>
