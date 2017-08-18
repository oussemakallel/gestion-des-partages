<?php 
spl_autoload_register(function ($class) {
    include  $class . '.php';
});


Class Serveur extends Modele
{
private $nomServ ;
private $nomAdmin ;
private $pwd ;
private $disques = Array() ;
private $id  ;




 public function __construct()
    {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 0:
                break;
                case 1:
                $this->nomServ   = $args[0];
                break ;    
                case 3:
                $this->nomServ   = $args[0];
                $this->nomAdmin  = $args[1];
                $this->pwd       = $args[2];               
                break;
                default:
                break;
            }
    }

public function getNomServ()
{
    return $this->nomServ ;
}
 
public function setNomServ($nomServ )
{
    $this->nomServ  = $nomServ ;
    return $this;
}

public function getNomAdmin ()
{
    return $this->nomAdmin ;
}
 
public function setNomAdmin($nomAdmin )
{
    $this->nomAdmin  = $nomAdmin ;
    return $this;
}

public function getPwd()
{
    return $this->pwd ;
}
 
public function setPwd ($pwd )
{
    $this->pwd  = $pwd ;
    return $this;
}

public function getDisques()
{
    return $this->disques;
}
 
public function setDisques($disques)
{
    $this->disques = $disques;
    return $this;
}

public function getId()
{
    return $this->id;
}
 
public function setId($id)
{
    $this->id = $id;
    return $this;
}

public function getServerById($id_serveur)
{
    $serveur = null ;
    $sql = 'select * from serveurs where id=?';
    $serveurs = $this->executerRequete($sql, array($id_serveur)); 
    if ($serveurs != null and count($serveurs)==1 ) {
       foreach ($serveurs as $serveur) {
           $this->nomServ  = $serveur['nomServ'] ;
           $this->nomAdmin =  $serveur['nomAdmin'] ;
           $this->pwd =$serveur['pwd'] ; 
           $this->id  =$serveur['id'] ;       
         }
    }
    return $this ;
}



//preparer la liste des disques de ce serveur courant

public function getDisquesServer()
{
    $disques = null;
    $listDisque = array() ;
    $id_serveur = $this->getId() ;
    $sql = 'select * from disques where id_serveur= ?';
    $disques= $this->executerRequete($sql, array($id_serveur)); 
    if ($disques != null) {
        $i=0 ;
       foreach ($disques as $disque) {
           $d = new Disque() ;
           $d->getDisque($id_serveur,$disque['nomdisque']) ; //M
           $d->setServeur($this->getServerById($id_serveur)) ;
           $listDisque[$i] = $d ;
           $i=$i+1 ;
       }
    }
    $this->disques=$listDisque ;
    return $listDisque ;
}
//à tester
public function getDisquesServername($nomserv)
{
    $disques = null;
    $listDisque = array() ;
    $id_serveur = $this->getIdServerByname($nomserv) ;
    $sql = 'select * from disques where id_serveur= ?';
    $disques= $this->executerRequete($sql, array($id_serveur)); 
    if ($disques != null) {
        $i=0 ;
       foreach ($disques as $disque) {
           $d = new Disque() ;
           $d->getDisque($id_serveur,$disque['nomdisque']) ; //M
           $d->setServeur($this->getServerById($id_serveur)) ;
           $listDisque[$i] = $d ;
           $i=$i+1 ;
       }
    }
    $this->disques=$listDisque ;
    return $listDisque ;
}

//renvoi un serveur complet 
public function mappingServ($nomServ)
{   
    $this->getServerByname($nomServ) ;
    $this->getDisquesServer() ;
    return $this ;
}


//renvoi un serveur sans liste de disques
public function getServerByname($nomServ)
{
    $serveur = null ;
    $sql = 'select * from serveurs where nomServ=?';
    $serveurs = $this->executerRequete($sql, array($nomServ)); 
    if ($serveurs != null and count($serveurs)==1 ) {
       foreach ($serveurs as $serveur) {
           $this->nomServ  = $serveur['nomServ'] ;
           $this->nomAdmin =  $serveur['nomAdmin'] ;
           $this->pwd =$serveur['pwd'] ; 
           $this->id  =$serveur['id'] ;       
         }
    }
    return $this ;
}


public function getIdServerByname($nomServ)
{
    $serveur = null ;
    $sql = 'select * from serveurs where nomServ=?';
    $serveurs = $this->executerRequete($sql, array($nomServ)); 
    if ($serveurs != null and count($serveurs)==1 ) {
       foreach ($serveurs as $serveur) {       
           return $serveur['id'] ;       
         }
    }
    
}


public function getAllServer()
{
  $sql = 'select * from serveurs ';
  $serveurs = $this->executerRequete($sql);
  $listServ=array(); 
  $i=0;
   foreach ($serveurs as $serveur) 
   {
           $s=new Serveur() ;
           $s->nomServ  = $serveur['nomServ'] ;
           $s->nomAdmin =  $serveur['nomAdmin'] ;
           $s->pwd =$serveur['pwd'] ; 
           $s->id  =$serveur['id'] ; 
           $s->getDisquesServer()  ; 
           $listServ[$i]=$s ;
           $i=$i+1;  
   }
   return $listServ ;

}


public function addServer($nomServ,$admin,$pwd)
{
     $nb=$this->searchServer($nomServ) ;
    if($nb==0)
    {  
      $sqlInsert='insert into serveurs (nomserv,nomAdmin,pwd) values(?,?,?)' ;
      $this->executerRequete($sqlInsert,array($nomServ,$admin,$pwd)) ;
    }
} 

public function searchServer($nomServ) 
{
    $sql = 'select * from serveurs where nomServ=?';
    $serveurs = $this->executerRequete($sql, array($nomServ)); 
    return $serveurs->rowCount() ;
}

public function editServer($id,$nomServ,$admin,$pwd)
{
  $sqlUpdate='update serveurs set nomServ=?,nomAdmin=?,pwd=? where id =?' ;
  $this->executerRequete($sqlUpdate, array($nomServ,$admin,$pwd,$id));
}
public function deleteServ($id)
{
  $sqlDelete='delete from serveurs where id = ?';
  $this->executerRequete($sqlDelete,array($id));
  $sqlDeleteDisque='delete from disques where id_serveur = ?' ;
  $this->executerRequete($sqlDeleteDisque,array($id)) ; 
}
public function pingServer($nomServ)
{

}


}
?>