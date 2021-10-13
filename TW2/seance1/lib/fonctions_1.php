<?php
//  créer les fonctions ici


/**
 * Returns
 * @param int $n
 * @return string
 **/
function afficheVar(int $n, String $s) : String {
  return "\$n vaut $n et \$s vaut $s";
}


/**
 *
 * @param int $n
 * @return int
 **/
function n_parag(String $texte, int $n) : String {
  $ch = "";
  for ($i=0; $i < $n; $i++){
    $ch .= "$texte\n";
  }
  return $ch;
}


function paragrapheTronque(String $s, int $i) : String {
  return substr($s, 0, $i);
}


function diminue(String $s) : String {
  $ch = "";
  for ($i=strlen($s); $i >= 0; $i--){
    $ch .= "<p>".paragrapheTronque($s, $i)."</p>\n";
  }
  return $ch;
}


function diminue_v2(String $s) : String {
  $ch = "";
  for ($i=strlen($s); $i >= 0; $i--){
    $ch .= "\t\t<li>".paragrapheTronque($s, $i)."</li>\n";
  }
  return "<ul>\n".$ch."</ul>\n";
}


function multiplication(int $n, int $i) : int {
  return $n * $i;
}


function tableMultiplication(int $n) : String {
  $ch = "";
  for ($i=1; $i <= 9; $i++){
    $ch .= "\t\t<li> $n * $i = ".multiplication($n, $i)."</li>\n";
  }
  return "<ul>\n".$ch."</ul>\n";
}


function tablesMultiplications() : String {
  $ch = "";
  for ($i=1; $i <= 9; $i++){
    $ch .= "<li>".tableMultiplication($i)."</li>\n";
  }
  return "<ul>\n".$ch."</ul>\n";
}


function ligneEntete() : String {
  $ch = "<tr>\n<th>*</th>\n";
  for ($i=1; $i <= 9; $i++){
    $ch .= "<th>$i</th>\n";
  }
  return $ch."</tr>\n";
}


function ligneTable(int $n) : String {
  $ch = "<tr>\n<th>$n</th>\n";
  for ($i=1; $i <= 9; $i++){
    $ch .= "<td>".multiplication($n, $i)."</td>\n";
  }
  return $ch."</tr>\n";
}


function tableauMult() : String {
  $ch = "<table id="."multiplications".">\n\t<thead>\n\t\t".ligneEntete()."\n\t</thead>\n\t<tbody>";
  for ($i=1; $i <= 9; $i++){
    $ch .= "\n\t\t".ligneTable($i);
  }
  return $ch."\n\t</tbody>\n</table>";
}

/**
 *
 *
 **/
function enP(String $s) : String {
  return "<p> ".implode(" </p> \n <p> ", explode("+", trim($s)))."</p>";
}


function enSpan(String $s) : String {
  return "<span> ".implode(" </span> \n <span> ", explode("-", trim($s)))."</span>";
}
?>
