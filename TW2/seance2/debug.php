<?php
/**
 * Indique au navigateur qu'il doit afficher du texte ordinaire, sans l'interpréter comme de l'HTML :
*/
header("Content-Type: text/plain;charset=UTF-8");

/**
 * Inclusion du fichier de définitions de fonctions :
 */
require("lib/BookReader.class.php");
require("lib/FileBookReader.class.php");
require_once("lib/fonctionsLivre.php");    // inclusion de fichier

/** Test question 1.1
 */

/** fonction de test
 *  reçoit comme argument un nom de fichier et affiche le résultat de readBook sur ce fichier
 */
function testReadBook($fileName){
    $dl = new FileBookReader($fileName);
    $book = $dl->readBook();
    echo "Résultat pour $fileName \n";
    print_r($book);
}

/** fonction de test de elementBuilder
 *  reçoit trois argumets qui sont des chaînes,  Le résultat est une chaîne contenant le code HTML d’unélément de type$elementType, et de contenu$content.
 *  Si $elementClassn’est pas la chaînevide, il désigne la valeur de l’attributclassde l’élément.
 */
function testelementBuilder(string $elementType,string  $content,string $elementClass="") {
  $element = elementBuilder($elementType, $content, $elementClass);
  echo "\nRésultat pour elementBuilder({$elementType}, {$content}, {$elementClass}) :\n";
  print($element)."\n\n";
}

/** fonction de test de authorsToHTML.
 *  reçoit comme argument une chaîne représentant les noms des auteurs, et renvoie une chaîne contenant le code HTML représentant les auteurs.
 */
function testauthorsToHTML (string $authors) {
  $element = authorsToHTML( $authors);
  echo "\nRésultat pour authorsToHTML({$authors}) : \n";
  print($element)."\n\n";
}

/** fonction de test de coverToHTML.
 *  reçoit comme argument une chaîne représentant le chemin vers cette image, renvoie une chaîne contenant le code HTML représentant l’image de couverture.
 */
function testcoverToHTML(string $fileName) {
  $element = coverToHTML( $fileName);
  echo "\nRésultat pour coverToHTML({$fileName}) : \n";
  print($element)."\n\n";
}

/** fonction de test de propertyToHTML.
 *  reçoit deux argumets qui sont des chaînes, Le résultat est une chaîne contenant le code HTML représentant la propriété.
 */
function testpropertyToHTML(string $propName, string $propValue) {
  $element = propertyToHTML($propName, $propValue);
  echo "\nRésultat pour propertyToHTML({$propName}, {$propValue}) : \n";
  print($element)."\n\n";
}

/** fonction de test de bookToHTML.
 *  reçoit un argument qu'est une table PHP représentant un livre et dont le résultat est une chaîne qui contient le code HTML correspondant (c’est à dire le code d’un élément article).
 */
function testbookToHTML(array $book) {
  $element = bookToHTML($book);
  echo "\nRésultat pour bookToHTML({$book}) : \n";
  print($element);
}

/** fonction de test libraryToHTML.
 * reçoit comme argument $datalayer qu'est la couche d’accès aux données de descriptions de livres. Le résultat
 * de la fonction est une une chaîne contenant le code HTML présentant l’ensemble des livres du fichier (une suite d’articles).
 */
function testlibraryToHTML(BookReader $datalayer) {
  $element = libraryToHTML($datalayer);
  echo "\nRésultat pour libraryToHTML() : \n";
  print($element);
}
/**
 * Lancement des tests :
 */

testelementBuilder('h2','La marque du diable','titre');
testelementBuilder('p','bla bla');

testauthorsToHTML('Marini - Desberg');

testcoverToHTML('scorpion.jpg');

testpropertyToHTML('auteurs', 'Marini - Desberg');

$onebook = new FileBookReader("data/exempleLivre1.txt");
$book = $onebook->readBook();
testbookToHTML($book);

testlibraryToHTML(new FileBookReader("data/livres.txt"));

// une description corretce de livre suivie de la fin de fichier
// doit produire un résultat correct
testReadBook('data/exempleLivre1.txt');

// une description de livre,(avec des espaces inutiles) suivie d'une ligne vide puis d'un autre texte à ignorer
// doit produire un résultat correct
testReadBook('data/exempleLivre2.txt');

// une description de livre incorrecte (manque ':' en ligne 2)
// doit déclencher une exception
testReadBook('data/exempleLivreErrone.txt');


//
//



/*
Voilà ce qui devrait s'afficher :
=================================

Résultat pour elementBuilder(h2, La marque du diable, titre) :
<h2 class="titre">La marque du diable</h2>


Résultat pour elementBuilder(p, bla bla, ) :
<p>bla bla</p>


Résultat pour authorsToHTML(Marini - Desberg) :
<span>Marini </span> <span> Desberg</span>


Résultat pour coverToHTML(scorpion.jpg) :
<img src="couvertures/scorpion.jpg" alt="image de couverture" />


Résultat pour propertyToHTML(auteurs, Marini - Desberg) :
<div class="auteurs"><span>Marini </span> <span> Desberg</span></div>


Résultat pour bookToHTML(Array) :
    <article class="livre">

			<div class="couverture"><img src="couvertures/scorpion.jpg" alt="image de couverture" /></div>
			<div class="description">
			<h2 class="titre">La marque du diable</h2>
			<div class="serie">Le Scorpion</div>
			<div class="auteurs"><span>Marini </span> <span> Desberg</span></div>
			<time class="annee">2000</time>
			<div class="categorie">bandes-dessinées</div>
			</div>

	    </article>


Résultat pour libraryToHTML() :
    <article class="livre">

			<div class="couverture"><img src="couvertures/dune.jpg" alt="image de couverture" /></div>
			<div class="description">
			<h2 class="titre">Dune</h2>
			<div class="auteurs"><span>Frank Herbert</span></div>
			<time class="annee">1965</time>
			<div class="categorie">science-fiction</div>
			</div>

	    </article>

	    <article class="livre">

			<div class="couverture"><img src="couvertures/tony-chu.jpg" alt="image de couverture" /></div>
			<div class="description">
			<h2 class="titre">Goût décès</h2>
			<div class="serie">Tony Chu - Détective Cannibale</div>
			<div class="auteurs"><span>John Layman </span> <span> Rob Guillory</span></div>
			<time class="annee">2010</time>
			<div class="categorie">bandes-dessinées</div>
			</div>

	    </article>

	    <article class="livre">

			<div class="couverture"><img src="couvertures/seigneur-des-anneaux.png" alt="image de couverture" /></div>
			<div class="description">
			<h2 class="titre">Le seigneur des anneaux</h2>
			<div class="auteurs"><span>JRR Tolkien</span></div>
			<time class="annee">1954</time>
			<div class="categorie">fantasy</div>
			</div>

	    </article>

	    <article class="livre">

			<div class="couverture"><img src="couvertures/fils-des-brumes.jpg" alt="image de couverture" /></div>
			<div class="description">
			<h2 class="titre">L'empire ultime</h2>
			<div class="serie">Fils des brumes</div>
			<div class="auteurs"><span>Brandon Sanderson</span></div>
			<time class="annee">2006</time>
			<div class="categorie">fantasy</div>
			</div>

	    </article>

	    <article class="livre">

			<div class="couverture"><img src="couvertures/scorpion.jpg" alt="image de couverture" /></div>
			<div class="description">
			<h2 class="titre">La marque du diable</h2>
			<div class="serie">Le Scorpion</div>
			<div class="auteurs"><span>Marini </span> <span> Desberg</span></div>
			<time class="annee">2000</time>
			<div class="categorie">bandes-dessinées</div>
			</div>

	    </article>

	    <article class="livre">

			<div class="couverture"><img src="couvertures/miles-vorkosigan.jpg" alt="image de couverture" /></div>
			<div class="description">
			<h2 class="titre">Miles Vorkosigan</h2>
			<div class="auteurs"><span>Lois McMaster Bujold</span></div>
			<time class="annee">1986</time>
			<div class="categorie">science-fiction</div>
			</div>

	    </article>


Résultat pour data/exempleLivre1.txt
Array
(
    [couverture] => scorpion.jpg
    [titre] => La marque du diable
    [serie] => Le Scorpion
    [auteurs] => Marini - Desberg
    [annee] => 2000
    [categorie] => bandes-dessinées
)
Résultat pour data/exempleLivre2.txt
Array
(
    [couverture] => scorpion.jpg
    [titre] => La marque du diable
    [serie] => Le Scorpion
    [auteurs] => Marini - Desberg
    [annee] => 2000
    [categorie] => bandes-dessinées
)
<br />
<b>Warning</b>:  fopen(data/exempleLivreErrone.txt): failed to open stream: No such file or directory in <b>/home/l2/bourahma/public_html/seance2/lib/FileBookReader.class.php</b> on line <b>11</b><br />
<br />
<b>Warning</b>:  fgets() expects parameter 1 to be resource, bool given in <b>/home/l2/bourahma/public_html/seance2/lib/FileBookReader.class.php</b> on line <b>27</b><br />
Résultat pour data/exempleLivreErrone.txt
*/

?>
