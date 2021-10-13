<?php
/**
 * Classe dédiée à l'interrogation de la base de données
 *
 */
class DataLayer {
	// private ?PDO $conn = NULL; // le typage des attributs est valide uniquement pour PHP>=7.4
	private  $conn = NULL; // connexion,  de type PDO

	/**
	 * @param $DSNFileName : file containing DSN
	 */
	function __construct(string $DSNFileName){
		$dsn = "uri:$DSNFileName";
		$this->conn = new PDO($dsn);
		// paramètres de fonctionnement de PDO :
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // déclenchement d'exception en cas d'erreur
		$this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC); // fetch renvoie une table associative
		// réglage d'un schéma par défaut :
		$this->conn->query('set search_path=livres');
	}

	/**
	 * Liste des livres de la base (renvoie un tableau de livres)
	 * un livre est représenté par une table associative
	 */
	function getBooks() : array {
		$sql = <<<EOD
			select titre, annee, categorie, serie, couverture, auteurs
			from livres_complets
EOD;
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/**
	 * Liste des auteurs (renvoie un tableau d'auteurs)
	 * chaque auteur est représenté par une table comportant les clés id et nom
	 */
	function getAuthors() : array {
	  $sql = <<<EDO
		   select * from auteurs
		EDO;
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function getYears() : array {
	  $sql = <<<EDO
		   select annee from livres_complets
		EDO;
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function getCategory() : array {
		$sql = <<<EDO
		  select distinct categorie from livres_complets
		EDO;
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function getBooksByCategory(string $Category) : array {
		$sql = <<<EDO
		  select titre, annee, categorie, serie, couverture, auteurs
			from livres_complets where categorie=:category
		EDO;

		$stmt = $this->conn->prepare($sql);
		$stmt->bindValue(':category', $Category);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function getBooksBySubString (string $word) : array {
		$sql = <<<EDO
			select titre, annee, categorie, serie, couverture, auteurs
			from livres_complets where titre LIKE '%:word%'
		EDO;

		$stmt = $this->conn->prepare($sql);
		$stmt->bindValue(':word', $word);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/**
	 * Recherche les livres de la base selon leur auteur (renvoie un tableau de livres)
	 * @param int $authorId : identifiant de l'auteur recherché
	 */
	function getBooksByAuthor(int $authorID) : array {
		$sql = <<<EOD
			select titre, annee, categorie, serie, couverture, auteurs
			from livres_complets
			where id in (select livre from ecriture where auteur=:authorid)
EOD;
    $stmt = $this->conn->prepare($sql);
		$stmt->bindValue(':authorid', $authorID);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/**
	 * Recherche les livres de la base selon l'année de parution (renvoie un tableau de livres)
	 * @param int $year : année de parution
	 */
	function getBooksByYear(int $year) : array {
		$sql = <<<EOD
			select titre, annee, categorie, serie, couverture, auteurs
			from livres_complets where annee=:year
EOD;
    $stmt = $this->conn->prepare($sql);
		$stmt->bindValue(':year', $year);
		$stmt->execute();
		return $stmt->fetchAll();
	}
// Pour les questions 4 et 5
	/**
	 * Recherche les livres de la base selon plusieurs critères cumulatifs (renvoie un tableau de livres)
	 * @param int $year : année de parution
	 * @param int $authorId : identifiant de l'auteur
	 *
	 * un critère est ignoré quand la valeur NULL est fournie
	 */
	function getBooksWithConds(?int $year=NULL, ?int $authorId=NULL, ?string $category, ?string $word){
		$sql = <<<EOD
			select titre, annee, categorie, serie, couverture, auteurs
			from livres_complets
EOD;
		$conds =[];  // tableau contenant les code SQL de chaque condition à appliquer
		$binds=[];   // association entre le nom de pseudo-variable et sa valeur
		if ($year !== NULL){
			$conds[] = "annee = :year";
			$binds[':year'] = $year;
		}
		if ($authorId !== NULL){
			$conds[] = "id in (select livre from ecriture where auteur=:authorid)";
			$binds[':authorid'] = $authorId;
		}
		if ($category !== NULL) {
			$conds[] = "categorie = :category";
			$binds[':category'] = $category;
		}
		if ($word !== NULL) {
			$conds[] = "titre LIKE '%:word%'";
			$binds[':word'] = $word;
		}
		if (count($conds)>0){ // il ya au moins une condition à appliquer ---> ajout d'ue clause where
			$sql .= " where ". implode(' and ', $conds); // les conditions sont reliées par AND
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($binds);
		return $stmt->fetchAll();
	}

}

?>
