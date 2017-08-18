<?php 
spl_autoload_register(function ($class) {
    include  $class . '.php';
});

Class Disque extends Modele {
private $nomDisque ;
private $espaceLibreHard ;
private $espaceTotalHard ;
private $espaceReserve   ;
private $espaceAllouable ;
private $serveur ;


public function __construct()
    {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 0:
                break;
                case 5:
                $this->nomDisque       = $args[0];
                $this->espaceLibreHard = $args[1];
                $this->espaceTotalHard = $args[2];
                $this->espaceReserve   = $args[3]  ;
                $this->espaceAllouable = $args[4]  ;
                break ;    
                case 1:
                $this->nomDisque =$args[0]  ;
                break;
                default:
                break;
            }
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
public function getEspaceLibreHard()
{
    return $this->espaceLibreHard;
}
 
public function setEspaceLibreHard($espaceLibreHard)
{
    $this->espaceLibreHard = $espaceLibreHard;
    return $this;
}
public function getEspaceTotalHard()
{
    return $this->espaceTotalHard;
}
 
public function setEspaceTotalHard($espaceTotalHard)
{
    $this->espaceTotalHard = $espaceTotalHard;
    return $this;
}
public function getEspaceReserve()
{
    return $this->espaceReserve;
}
 
public function setEspaceReserve($espaceReserve)
{
    $this->espaceReserve = $espaceReserve;
    return $this;
}


public function getEspaceAllouable()
{
    return $this->espaceAllouable;
}
 
public function setEspaceAllouable($espaceAllouable)
{
    $this->espaceAllouable = $espaceAllouable;
    return $this;
}
public function getServeur()
{
    return $this->serveur;
}
 
public function setServeur($serveur)
{
    $this->serveur = $serveur;
    return $this;
}


//renvoie disque 
public function getDisque($id_serveur,$nomdisque)
{
    
    $sql = 'select * from disques where id_serveur=? and nomdisque=?';
    $disquesR = $this->executerRequete($sql, array($id_serveur,$nomdisque)); 
    if ($disquesR != null and count($disquesR )==1 ) {
       foreach ($disquesR as $disque ) {
                $this->nomDisque       = $disque['nomdisque'];
                $this->espaceLibreHard = $disque['espacelibre'];
                $this->espaceTotalHard = $disque['espacetotal'];
                $this->espaceReserve   = $disque['espaceReserve']  ;
                $this->espaceAllouable = $disque['espaceAllouable'] ;
                $this->serveur         = (new Serveur())->getServerById($id_serveur) ;

       }
    }
    return $this ;
}

//utile pour scanServ
public function calculateSizeOfActualSharesNoDemanded($serveur,$disque)
{ 
  $size=0;
  $sql = 'select sum(tailleActuel) as sizeofShares from partages where nomServ= ? and disque= ? and id_demande = ?' ;  
  $sql2 = 'select *  from partages where nomServ= ? and disque= ? and id_demande = ?' ; 
  $resultSet2=$this->executerRequete($sql2,array($serveur,$disque,0)) ;
  if ($resultSet2->rowCount()==0) {
      return $size ;
  }
  else
  {
    $resultSet=$this->executerRequete($sql,array($serveur,$disque,0))  ;
    foreach ($resultSet as $value) 
       {
        $size= $value['sizeofShares'];
       }
    return number_format ( $size , 6 ) ;
  }
}


//utile pour scanServ
public function calculateSizeOfActualShares($serveur,$disque)
{ 
  $size=0;
  $sql = 'select sum(tailleActuel) as sizeofShares from partages where nomServ= ? and disque= ?' ;  
  $sql2 = 'select *  from partages where nomServ= ? and disque= ?' ; 
  $resultSet2=$this->executerRequete($sql2,array($serveur,$disque)) ;
  if ($resultSet2->rowCount()==0) {
      return $size ;
  }
  else
  {
    $resultSet=$this->executerRequete($sql,array($serveur,$disque))  ;
    foreach ($resultSet as $value) 
       {
        $size= $value['sizeofShares'];
       }
    return number_format ( $size , 6 ) ;
  }
}



//utile pour scanServ
public function calculateReservedSpace($serveur,$disque)
{
    $reservedSpace=0;
    $sql='select sum(quota) as somme from demandes where nomServ=? and nomDisque=? and ((etat = ? and type = ?) or (etat = ? and type = ?) or (etat = ? and type = ?) or (etat = ? and type = ?))' ;
    $etat1="T" ;
    $type1="C" ;

    $etat2="T" ;
    $type2="M" ;

    $etat3="A" ;
    $type3="C" ;

    $etat4="A" ;
    $type4="M" ;

    $etat5="R" ;
    $type5="M" ;

    $etat6="N" ;
    $type6="M" ;

    $sql2='select SUM(quota) as somme from partages where id_demande in (select id from demandes where ((etat=? and type=?) or (etat=? and type=?)) and nomServ=? and nomdisque=? )' ;

    $reservedSpace1=$this->executerRequete($sql,array($serveur,$disque,$etat1,$type1,$etat2,$type2,$etat3,$type3,$etat4,$type4)) ;
    $reservedSpace2=$this->executerRequete($sql2,array($etat5,$type5,$etat6,$type6,$serveur,$disque)) ;
        foreach ($reservedSpace1 as $s) 
        {
            $reservedSpace=$s['somme'] ;
            
         }

         foreach ($reservedSpace2 as $s2) 
         {
            $reservedSpace=$s2['somme']+$reservedSpace;
            
         }   

    return $reservedSpace; 
}

//utile pour insertOrUpdateDisqueInfo
public function searchDisque($serveur,$disque)
{
   
   $s =new Serveur() ;
   $id_serveur=$s->getIdServerByname($serveur);
   $sql='select * from disques where id_serveur = ? and nomDisque= ?' ;
   $resultSet=$this->executerRequete($sql,array($id_serveur,$disque)) ;
   if( $resultSet->rowCount()==0) 
   {
    $tab=array() ;
    $tab[0]=0;
    $tab[1]=$id_serveur;
    return $tab ;
   }
   else
   {
     $tab = array() ;
    foreach ($resultSet as  $value) {
       $tab[0]=$value['id'] ;
       $tab[1]=$value['id_serveur'] ;
    }
    return $tab ;
   }
}

//utile pour scanServ
public function insertOrUpdateDisqueInfo($serveur,$nomDisque,$espacelibre,$espacetotal,$espaceReserve,$espaceAllouable)
{
     $tab= $this->searchDisque($serveur,$nomDisque) ;

    if ($tab[0]==0) 
    {
       $sqlInsert='insert into disques (id_serveur,nomDisque,espacelibre,espacetotal,espaceReserve,espaceAllouable) values(?,?,?,?,?,?)';
       $this->executerRequete($sqlInsert,array($tab[1],$nomDisque,$espacelibre,$espacetotal,$espaceReserve,$espaceAllouable)) ; 
    }
    else
    {
      $sqlUpdate='update disques set espacelibre=?,espacetotal=?,espaceReserve=?,espaceAllouable=? where id_serveur = ? and nomDisque=?';
       $this->executerRequete($sqlUpdate,array($espacelibre,$espacetotal,$espaceReserve,$espaceAllouable,$tab[1],$nomDisque)) ;   
    }
   
   
}

//delete disque from serveur if does not exist on the local network  stand for one server
//we have to repeat that code foreach server 
public function deleteDisqueInfo($list)
{
   $s =new Serveur() ;
   $id_serveur=$s->getIdServerByname($list[6]);
   $sql='select * from disques where id_serveur=?' ;
   $sqlDelete='delete from disques where nomdisque=? and id_serveur=?';
   $resultSet=$this->executerRequete($sql,array($id_serveur)) ;
   foreach ($resultSet as $disqueInfo) 
   {
      
           $i=3 ;
           $verif = true ;     
            while ( $i < sizeof($list) and $verif )
            {
              if($disqueInfo['nomdisque'] == $list[$i]  and $disqueInfo['id_serveur'] ==$id_serveur )
              {
                $verif = false ;
              }          
              $i=$i+4 ;       
            }
            if ($verif) 
            {
              $this->executerRequete($sqlDelete,array($disqueInfo['nomdisque'],$disqueInfo['id_serveur'])) ;
            }

   }

}


//scan server  $list stand for one server
public function scanDisquesVBS($list)
{
     //$s =new Serveur() ;
     //$s->getIdServerByname($nomServ)
    //$this->calculateReservedSpace($serveur,$disque)

    $i=3 ;
    while ($i<sizeof($list)) {
    //insertOrUpdateDisqueInfo($serveur,$nomDisque,$espacelibre,$espacetotal,$espaceReserve,$espaceAllouable)
    $espaceReserve=0 ;
    $sizeActual=0;
    $SizeOfActualSharesNoDemanded=0;
    $sizeActual   =$this->calculateSizeOfActualShares($list[$i+3],$list[$i]) ;
    $espaceReserve=$this->calculateReservedSpace($list[$i+3],$list[$i]) ;
    $SizeOfActualSharesNoDemanded=$this->calculateSizeOfActualSharesNoDemanded($list[$i+3],$list[$i]) ;
    
 

    $this->insertOrUpdateDisqueInfo($list[$i+3],$list[$i],$list[$i+2],$list[$i+1],$espaceReserve,$list[$i+2]-$espaceReserve+($sizeActual-$SizeOfActualSharesNoDemanded) );
    
    
        $i=$i+4 ;
    }


}



}

?>