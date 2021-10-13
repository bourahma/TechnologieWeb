<?php

/**
 * Returns an HTML5 tag built from data that given as parameters.
 * @param string $elementType The name of the element (tag).
 * @param string $content The content of this element.
 * @param string $elementClass The value of this class attribute.
 * @return string an HTML5 tag.
 */
function elementBuilder(string $elementType,string  $content,string $elementClass="") : string {
  if (! $elementClass) {
    return "<".$elementType.">".$content."</".$elementType.">";
  }
  return "<".$elementType." class=\"".$elementClass."\">".$content."</".$elementType.">";
}

/**
 * Returns a string containing the HTML code representing the authors that passed on parameter.
 * @param string $authors The authors names.
 * @return string a string containing the HTML code representing the authors.
 */
function authorsToHTML(string $authors) : string {
  return "<span>".implode("</span> <span>",explode("-", $authors))."</span>";
}

/**
 * Returns a string containing the HTML code representing the cover image.
 * @param string $fileName The path to this image.
 * @return string a string containing the HTML code representing the cover image.
 */
function coverToHTML(string $fileName) : string {
  return "<img src=\"couvertures/".$fileName."\" alt=\"image de couverture\" />";
}

/**
 * Returns a string containing the HTML code representing the property.
 * @param string $propName The name of the property.
 * @param string $propValue
 * @return string The value of this element class attribute.
 */
function propertyToHTML(string $propName, string $propValue) : string {
  if ($propName === "titre") {
    return elementBuilder('h2', $propValue, $propName);
  } elseif ($propName === "auteurs") {
     return elementBuilder('div', authorsToHTML($propValue), $propName);
  } elseif ($propName === "annee") {
     return elementBuilder('time', $propValue, $propName);
  } elseif ($propName === "couverture") {
     return elementBuilder('div', coverToHTML($propValue), $propName);
  } else {
     return elementBuilder('div', $propValue, $propName);
  }
}

/**
 * Returns a string containing the HTML code of properties representing a book.
 * @param array $book An array which contains infomations of this book.
 * @return string A string containing the HTML code of properties representing a book.
 */
function bookToHTML(array $book) : string { //"\n\t    </article>\n\n\t    ";
  $res  = "    <article class=\"livre\">\n\n\t\t\t";
  $res2 = "<div class=\"description\">\n\t\t\t";
  foreach($book as $key=>$value){
      if($key === 'couverture') {
        $res1 = propertyToHTML($key,$value)."\n\t\t\t";
      } else {
        $res2 .= propertyToHTML($key,$value)."\n\t\t\t";
      }
  }
  return $res.$res1.$res2."</div>\n\n\t    </article>\n\n\t";
}


// exercice 2


/**
 * Returns a string containing the HTML code of properties representing a library of books.
 * @param BookReader $datalayer An array which contains infomations of this book.
 * @return string A string containing the HTML code of properties representing a library of books..
 */
function libraryToHTML(BookReader $datalayer) : string {
  $html = "";
  $book = $datalayer;
  $livre = $book->readBook();
  while ($livre !== NULL) {
    $html .= bookToHTML($livre);
    $livre = $book->readBook();
  }
  $livre = $book->closeFile();
  return $html."\n";
}

?>
