<?php
class DataLayer {
	// private ?PDO $conn = NULL; // le typage des attributs est valide uniquement pour PHP>=7.4

	private  $conn = NULL; // connexion de type PDO   compat PHP<=7.3
	
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
		$this->connexion->query('set search_path=authent');
	}
    
    
    function authentificationProvisoire(string $login, string $password) : ?Identite{

             $sql = <<<EOD
             select
             login, nom, prenom
             from users
             where login = :login and password = :password
EOD;

             $stmt = $this->connexion->prepare($sql);
             $stmt->bindValue(':login', $login);
             $stmt->bindValue(':password', $password);
             $stmt->execute();
             $info = $stmt->fetch();
             if ($info)
                 return new Identite($info['login'], $info['nom'], $info['prenom']);
             else
                 return NULL;
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
                 return NULL;
    }
    /**
    * @return bool indiquant si l'ajout a été réalisé
    */
    function createUser(string $login, string $password, string $nom, string $prenom) : bool	 {
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
        $info = $stmt->fetch();
       
        return TRUE;
        }
        
        catch(PDOException $e){
            throw new PDOException("Error Input Requests");
        }

     }
	
}
?>
