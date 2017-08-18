<?php
spl_autoload_register(function ($class) {
    include  $class . '.php';
}); 
class Demande extends Modele
{

private $id ; 
private $nomServ ;
private $nomDisque;
private $nomPartage ;
private $etat ;
private $quota ; 
private $demandeur;
private $type  ;
private $listCollaborateur = array() ;

 public function __construct()
    {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 0:
                break;
                case 3:
                $this->nomPartage   = $args[0];
                $this->quota        = $args[1];
                $this->demandeur    = $args[3];
                break ;    
                default:
                break;
            }
    }

 public function getId ()
   {
       return $this->id ;
   }
    
   public function setId ($id )
   {
       $this->id  = $id ;
       return $this;
   }  

public function getNomServ()
{
    return $this->nomServ;
}
 
public function setNomServ($nomServ)
{
    $this->nomServ = $nomServ;
    return $this;
}

public function getNomDisque()
{
    return $this->nomDisque;
}
 
public function setNomDisque($nomDisque)
{
    $this->nomDisque = $nomDisque;
    return $this;
}

public function getNomPartage()
{
    return $this->nomPartage;
}
 
public function setNomPartage($nomPartage)
{
    $this->nomPartage = $nomPartage;
    return $this;
}
public function getEtat()
{
    return $this->etat;
}
 
public function setEtat($etat)
{
    $this->etat = $etat;
    return $this;
}

public function getQuota()
 {
     return $this->quota;
 }
  
 public function setQuota($quota)
 {
     $this->quota = $quota;
     return $this;
 } 

public function getDemandeur()
{
    return $this->demandeur;
}
 
public function setDemandeur($demandeur)
{
    $this->demandeur = $demandeur;
    return $this;
}
public function getType()
{
    return $this->type;
}
 
public function setType($type)
{
    $this->type = $type;
    return $this;
}

public function getListCollaborateur()
{
    return $this->listCollaborateur;
}
 
public function setListCollaborateur($listCollaborateur)
{
    $this->listCollaborateur = $listCollaborateur;
    return $this;
}


public function getDemande($id)
{
    $demandes=null ;
    $sql = 'select * from demandes where id=?';
    $demandes = $this->executerRequete($sql, array($id)); 
    if ($demandes != null and $demandes->rowCount()==1 ) {
       foreach ($demandes as $demande) 
       {
                $this->id              = $demande['id'] ;
                $this->nomServ         = $demande['nomServ'];
                $this->nomDisque       = $demande['nomDisque']  ;
                $this->nomPartage      = $demande['nomPartage'];
                $this->etat            = $demande['etat'] ;
                $this->quota           = $demande['quota'];
                $this->demandeur       = $demande['demandeur'] ;
                $this->type            = $demande['type']; 
                $this->getCollaborateur($demande['id'] ) ;

       }
        return $this ;
    }
    return null;
    
}
    public function closeDemand($id)
{
        $sql = 'update demandes set etat = ? where id = ? and (etat = ? or etat= ?)';
        $demandes = $this->executerRequete($sql, array('T',$id,'A','E'));
        
}

public function closeerrDemand($id)
{
        $sql = 'update demandes set etat = ? where id = ? and (etat = ? or etat= ?)';
        $demandes = $this->executerRequete($sql, array('E',$id,'A','E'));
        
}


//on n'utilise pas cette fonction en dehors du fichier php c'est unutile , on ai une listedecollaborateur dans cet objet
public function getCollaborateur($id_demande)
{
  
  $sql='select * from demandespermission where id_demande = ?'    ;
  $collaborateurs=$this->executerRequete($sql,array($id_demande)) ;
  $colls = array() ;
  $i=0;
  foreach ($collaborateurs as $coll) {
  	$colls[$i]=new Permission($coll['utilisateur'],$coll['permission']) ;
  	$i=$i+1 ;
  }
  $this->setListCollaborateur($colls); 
  return $colls ;
}



//utile pour utilisateur et l'admin renvoie une liste de demandes selon le type choisi et matricule
public function getDemandesByMatricule($matricule,$type)
{
    $listDeDemandes=array() ;
    $sql='select * from demandes where demandeur=? and type=?';
    $demandes=$this->executerRequete($sql, array($matricule,$type));
    $i=0;
    foreach ($demandes as $demande) 
    {
     $d = new Demande() ;
     $listDeDemandes[$i]=$d->getDemande($demande['id']) ;
     $i=$i+1;	
    }
    return $listDeDemandes ;
}
//utile pour l'administrateur renvoie une liste de demandes selon le type choisi
public function getAllDemandes($type)
{
    $listDeDemandes=array() ;
    $sql='select * from demandes where type=?';
    $demandes=$this->executerRequete($sql, array($type));
    $i=0;
    foreach ($demandes as $demande) 
    {
     $d = new Demande() ;
     $listDeDemandes[$i]=$d->getDemande($demande['id']) ;
     $i=$i+1;	
    }
    return $listDeDemandes ;
}


}

?>