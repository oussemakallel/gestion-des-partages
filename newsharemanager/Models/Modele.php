<?php
spl_autoload_register(function ($class) {
    include  $class . '.php';
}); 

 Abstract class Modele {

  // Objet PDO d'accès à la BD
  private $bdd;
  protected $lastIndex ;

  public function getLastIndex()
  {
      return $this->lastIndex;
  }
   
  public function setLastIndex($lastIndex)
  {
      $this->lastIndex = $lastIndex;
      return $this;
  }
  protected function countLine($sql,$params= null)
  {
     $resultSet=$this->executerRequete($sql, $params )   ; 
     return $resultSet->fetchColumn() ;
  }

  // Exécute une requête SQL éventuellement paramétrée
  protected function executerRequete($sql, $params = null) {
    if ($params == null) {
      $resultat = $this->getBdd()->query($sql);    // exécution directe
       $this->lastIndex = $this->bdd->lastInsertId() ;
       
    }
    else {
      $resultat = $this->getBdd()->prepare($sql);  // requête préparée
      $resultat->execute($params);
      $this->lastIndex = $this->bdd->lastInsertId() ;
      
    }
    return $resultat;
  }

  // Renvoie un objet de connexion à la BD en initialisant la connexion au besoin
  private function getBdd() {
    if ($this->bdd == null) {
      $configuration = new Config() ;

      // Création de la connexion
      $this->bdd = new PDO('mysql:host='.$configuration->getDataBaseHostname().';dbname='.$configuration->getDataBase().';charset=utf8',$configuration->getDataBaseUsername(), $configuration->getDataBasePassword(), array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    return $this->bdd;
  }

}





/*----------------------------TEST----------------------------------------------------
$modele = new Modele() ;
  $sql = 'insert into personnels(matricule, nom, prenom, droit)'
      . ' values(?, ?, ?, ?)';
    //$date = date(DATE_W3C);  // Récupère la date courante
    $modele->executerRequete($sql, array("xxlcv", "ben garbi","Samir", "Utilisateur"));
  ---------------------------------------------------------------------------------------
  */  
 
?>