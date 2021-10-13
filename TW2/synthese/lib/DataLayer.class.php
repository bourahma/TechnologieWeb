<?php
class DataLayer {
	// private ?PDO $conn = NULL; // le typage des attributs est valide uniquement pour PHP>=7.4

	private  $connexion = NULL; // connexion de type PDO   compat PHP<=7.3
	
	/**
	 * @param $DSNFileName : file containing DSN 
	 */
	function __construct(string $DSNFileName){
		$dsn = "uri:$DSNFileName";
		$this->connexion = new PDO($dsn);
		// paramètres de fonctionnement de PDO :
		$this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // déclenchement d'exception en cas d'erreur
		$this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC); // fetch renvoie une table associative
		// réglage d'un schéma par défaut :
		$this->connexion->query('set search_path=communes_mel, authent');
	}
    
	/**
	 * Liste des territoires
	 * @return array tableau de territoires
	 * chaque territoire comporte les clés :
		* id (identifiant, entier positif),
		* nom (chaîne),
		* min_lat (latitude minimale, flottant),
		* min_lon (longitude minimale, flottant),
		* max_lat, max_lon
	 */
	function getTerritoires(): array {
		$sql = "select id, nom , min_lat, min_lon, max_lat, max_lon from territoires join bb_territoires on id=territoire";
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute();
		$res= $stmt->fetchAll();
		return $res;
	}
	
	/**
	 * Liste de communes correspondant à certains critères
	 * @param territoire : territoire des communes cherchées
	 * @return array tableau de communes (info simples)
	 * chaque commune comporte les clés :
		* insee (chaîne),
		* nom (chaîne),
		* lat, lon 
		* min_lat (latitude minimale, flottant),
		* min_lon (longitude minimale, flottant),
		* max_lat, max_lon
	 */
	function getCommunes(?int $territoire=NULL): array {
		$sql = <<<EOD
			select insee, nom, lat, lon, min_lat, min_lon, max_lat, max_lon
				from communes_mel.communes
				natural join bb_communes
EOD;
		$conds =[];  // tableau contenant les code SQL de chaque condition à appliquer
		$binds=[];   // association entre le nom de pseudo-variable et sa valeur
		if ($territoire !== NULL){
			$conds[] = "territoire = :territoire";
			$binds[':territoire'] = $territoire;
		}
		if (count($conds)>0){ // il ya au moins une condition à appliquer ---> ajout d'ue clause where
			$sql .= " where ". implode(' and ', $conds); // les conditions sont reliées par AND
		}
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute($binds);
		$res= $stmt->fetchAll() ;
		return $res;
	}
	
	
	/**
	 * Information détaillée sur une commune
	 * @param insee : code insee de la commune
	 * @return commune ou NULL si commune inexistante
	 * l'objet commune comporte les clés :
	 *	insee, nom, nom_terr, surface, perimetre, pop2016, lat, lon, geo_shape
	 */
	function getDetails(string $insee): ?array {
		$sql = <<<EOD
			select insee, communes.nom, territoires.nom as nom_terr, surface, perimetre, population.pop_totale as pop2016,
			lat, lon, geo_shape   from communes 
			join communes_mel.territoires on id=territoire
			natural left join communes_mel.population
			where (recensement=2016 or recensement is null) and insee=:insee
EOD;
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute([':insee'=>$insee]);
		$res= $stmt->fetch() ;
		return $res ? $res : NULL;
	}
    
    function authentification(string $login, string $password) : ?Identite{ // version password hash  
        
        $sql1 = <<<EOD
             select
             password
             from users
             where login = :login 
EOD;

             $stmt1 = $this->connexion->prepare($sql1);
             $stmt1->bindValue(':login', $login);
             $stmt1->execute();
             $var = $stmt1->fetch();
        
             $sql = <<<EOD
             select
             login, nom, prenom
             from users
             where login = :login and password = :password
EOD;
                 
             $stmt = $this->connexion->prepare($sql);
        
             $stmt->bindValue(':login', $login);
             $stmt->bindValue(':password', crypt($password,$var['password']));
        
             $stmt->execute();
             $info = $stmt->fetch();
            
             if ($info)
                 return new Identite($info['login'], $info['nom'], $info['prenom']);
             else
                 throw new PDOException("Error Input Requests");
    }
    
    /**
    * @return bool indiquant si l'ajout a été réalisé
    */
    function createUser(string $login, string $password, string $nom, string $prenom){
        try{
        $sql = <<<EOD
        insert into "users" (login, password, nom, prenom)
        values (:login, :password, :nom, :prenom)
EOD;

        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':login',$login);
        $pass = password_hash($password,CRYPT_BLOWFISH);
        $stmt->bindValue(':password',$pass);
        $stmt->bindValue(':nom',$nom);
        $stmt->bindValue(':prenom',$prenom);
        $stmt->execute();
        //$info = $stmt->fetch();
       
        return ['login'=>$login,'nom'=>$nom,'prenom'=>$prenom];
        }
        
        catch(PDOException $e){
            throw new PDOException("Error Input Requests");
        }

     }

    /**
     * Recherche les livres de la base selon plusieurs critères cumulatifs (renvoie un tableau de communes)
     * @param int $territoire : le territoire
     * @param string $nom : le nom de territoire
     * @param int $surface_min : surface minimum
     * @param int $pop_totale : population totale
     * @param int $recensement : l'année
     *
     * un critère est ignoré quand la valeur NULL est fournie
     */
    function getCommunesWithConds(?int $territoire=NULL, ?string $nom=NULL, ?int $surface_min=NULL, ?int $pop_totale=NULL, ?int $recensement=NULL){
		$sql = <<<EOD
			select insee, nom, surface, lat, lon, min_lat, min_lon, max_lat, max_lon
				from communes_mel.communes
				natural join bb_communes
                natural join population
EOD;
        $conds =[];   
        $binds=[];      
		if ($territoire !== NULL){
			$conds[] = "territoire = :territoire";
			$binds[':territoire'] = $territoire;
		}
        if ($nom !== NULL){
            $conds[] = "nom ILIKE :noms ";
            $binds[':noms'] = "%$nom%";
        }
        if ($surface_min !== NULL){
            $conds[] = "surface > :surfs";
            $binds[':surfs'] = $surface_min;
        }        
        if ($pop_totale !== NULL){
            $conds[] = "pop_totale > :pop_totale";
            $binds[':pop_totale'] = $pop_totale;
        }     
        if ($recensement !== NULL){
            $conds[] = "recensement = :recensement";
            $binds[':recensement'] = $recensement;
        }
        if (count($conds)>0){
            $sql .= " where ". implode(' and ', $conds);
        }
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute($binds);
        return $stmt->fetchAll();
    }
}
?>
