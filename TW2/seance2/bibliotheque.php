<?php

// inclusion du fichier lib/BookReader.php :
require("lib/BookReader.class.php");

// inclusion du fichier lib/FileBookReader.php :
require("lib/FileBookReader.class.php");

// inclusion du fichier lib/fonctionsLivre.php :
require("lib/fonctionsLivre.php");


// Lecture  du fichier et mémorisation dans des variables PHP :
$booksHTML = libraryToHTML(new FileBookReader('data/livres.txt'));

require("views/AllBooks.php");

?>
