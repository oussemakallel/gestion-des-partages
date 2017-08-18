<?php
spl_autoload_register(function ($class) {
    include  $class . '.php';
}); 

Class Administrateur extends Personnel
{
	private $partages = array();



 public function __construct()
    {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 0:                    
                break;
                case 3:
                parent::__construct($args[0], $args[1], $args[2],"Admin");
                    break;
                 default:
                    break;
            }
    }





/*public function __construct($matricule, $nom, $prenom)
    {
        parent::__construct($matricule, $nom, $prenom,"Admin");
        
    }
*/

public function getPartages()
   {
    return $this->partages;
   }
 
public function setPartages($partages)
   {
    $this->partages = $partages;
    return $this;
   }

public function consultAllShares()
{
  $partage=new Partage() ;
  return $partage->consultAllShares() ;
}


public function consulterAllDemandes($type)
{
  $demande=new Demande() ;
  $demandes=$demande->getAllDemandes($type) ;
  return $demandes;
}



public function searchDemande_Admin($id)
{
     $sql='select * from demandes where id = ?';
     $resultSet = $this->executerRequete($sql,array($id)) ;
     return $resultSet->rowCount();
}


//Creation demande premiére fois 
 public function approuverDemandes($id_demande,$nomPartage,$quota,$users,$permissions,$serveur,$disque)
 {
    $demande=$this->searchDemande($id_demande);
    
    if ( $demande['etat'] == "N" )
     {
          $this->updateDemandePartage_Admin($id_demande,$nomPartage,$quota,$serveur,$disque) ; 
          
          $this->deleteCollaborators($id_demande) ;  
          $i=0 ;

          foreach ($users as $user) 
          {
            $this->insertNewCollaborator($id_demande,$user,$permissions[$i])  ;
            $i=$i+1 ;
          }

 /*NOTIF*/
       $sqlNotif ='insert into notification (destinataire,message,type) values(?,?,?)';
       $this->executerRequete($sqlNotif,array($demande['demandeur'],"Création approuvée ::".$demande['nomPartage'],"SUCCESS")) ;
     /*NOTIF*/
         $this->filltasks($id_demande,$demande['type']);
    }
    else
    {
      //echo "Déja approuvé";
    }
 } 

//Creation première fois 
public function updateDemandePartage_Admin($id,$nomPartage,$quota,$serveur,$disque)
{
   $demande=$this->searchDemande_Admin($id) ; 
   if($nomPartage != "" and $quota != "" and $demande != 0 )
   {
      $sqlUpdateDemande ='update demandes set nomPartage=?,etat=?,quota=?,nomServ=?,nomDisque=?,type=? where id = ? and etat = ?';
      $this->executerRequete($sqlUpdateDemande, array($nomPartage,"A",$quota,$serveur,$disque,"C",$id,"N"));
   } 
} 



//Modification d'une demande
 public function approuverDemandeEdited($id_demande,$nomPartage,$quota,$users=null,$permissions=null)
 {
    $demande=$this->searchDemande($id_demande);
  //  echo $demande['type'] ;
    
    if ($demande['etat'] == "T" or $demande['etat'] == "N" )
     {
          $this->updateDemandePartage_AdminEdite($id_demande,$nomPartage,$quota) ; 
          
          $this->deleteCollaborators($id_demande) ;  

          $i=0 ;
          if($users!=null and $permissions!=null)
          {
            
          foreach ($users as $user) 
          {
            $this->insertNewCollaborator($id_demande,$user,$permissions[$i])  ;
            $i=$i+1 ;
          }
        }


    /*NOTIF*/
       $sqlNotif ='insert into notification (destinataire,message,type) values(?,?,?)';
       $this->executerRequete($sqlNotif,array($demande['demandeur'],"Modification approuvée ::".$demande['nomPartage'],"SUCCESS")) ;
     /*NOTIF*/
         $this->filltasks($id_demande,$demande['type']);
    }
    else
    {
       //echo "Déja approuvé";
    }
 } 

//Modification d'une demande
public function updateDemandePartage_AdminEdite($id,$nomPartage,$quota)
{
   $demande=$this->searchDemande_Admin($id) ; 
   if($nomPartage != "" and $quota != "" and $demande != 0 )
   {
      $sqlUpdateDemande ='update demandes set nomPartage=?,etat=?,quota=?,type=? where id = ? and ( etat = ? or etat = ? )';
      $this->executerRequete($sqlUpdateDemande, array($nomPartage,"A",$quota,"M",$id,"N","T"));
   } 
}



public function ConfirmDeletePartage($id_demande)
{
   $sqlUpdate='update demandes set etat = ? where id = ? and etat = ?' ;
   $this->executerRequete($sqlUpdate,array("A",$id_demande,"N")) ;
   $demande=$this->searchDemande($id_demande);  
    /*NOTIF*/ 
    $sqlNotif ='insert into notification (destinataire,message,type) values(?,?,?)';
       $this->executerRequete($sqlNotif,array($demande['demandeur'],"Suppression approuvée ::".$demande['nomPartage'],"SUCCESS")) ;
     /*NOTIF*/
   $this->filltasks($id_demande,"S") ;

}
public function generateErrorNotif($id_Task,$msg)
{ 
    /*NOTIF*/ 
    
          $admins=$this->getAdministrators() ;
          foreach ($admins as $admin)
           {
            $sqlNotif ='insert into notification (destinataire,message,type) values(?,?,?)';
            $this->executerRequete($sqlNotif,array($admin['matricule'],'TASK N°'.$id_Task.' : '.$msg,"ERROR")) ;      
          }
       
}

public function generateSuccessNotif($id_Task,$msg)
{ 
    /*NOTIF*/ 
    
          $admins=$this->getAdministrators() ;
          foreach ($admins as $admin)
           {
            $sqlNotif ='insert into notification (destinataire,message,type) values(?,?,?)';
            $this->executerRequete($sqlNotif,array($admin['matricule'],'TASK N°'.$id_Task.' : '.$msg,"Success")) ;      
          }
       
}


 public function filltasks($id_demande,$type)
 {
  $sqlInsert='insert into taches (id_Demande,type) values(?,?)' ;
  $this->executerRequete($sqlInsert,array($id_demande,$type)) ;
 }  

 public function refuserDemande($id_demande)
 {
    $demande=$this->searchDemande($id_demande);
     /*NOTIF*/
    if ($demande['etat']=="N") {
       $sqlNotif ='insert into notification (destinataire,message,type) values(?,?,?)';
       $this->executerRequete($sqlNotif,array($demande['demandeur'],"demande refusé ::".$demande['nomPartage'],"error")) ;
    }
     /*NOTIF*/
   $sqlUpdate='update demandes set etat = ? where id = ? and etat = ?' ;
   $this->executerRequete($sqlUpdate,array("R",$id_demande,"N")) ;
 }
 



public function getAdministrators()
{
  $sql='select * from personnels where droit = ? '     ;
  $admins=$this->executerRequete($sql,array("Admin"))  ;
  return $admins ;    
}


public function getAllTasks()
{
  $sql = 'select * from taches ' ;
  $resultSet=$this->executerRequete($sql) ;
  return $resultSet ;
}
public function getundoneTasks()
{
  $sql = 'select * from taches where NOT etat = ? AND NOT etat=? AND NOT etat=?' ;
  $etat1 = "T" ;
  $etat2 = "P" ;
  $etat3="E" ;
  $resultSet=$this->executerRequete($sql,array($etat1,$etat2,$etat3)) ;

  return $resultSet ;
}
public function markTask($id)
{
  $sql = 'update taches set etat = ? where id = ? and etat = ?' ;
  $resultSet=$this->executerRequete($sql,array('P',$id,'A')) ;
  
}
public function setExecTask($etat,$output,$id)
{
  $sql = 'update taches set res_exec = ?,etat = ? where id = ? and etat = ?' ;
  $resultSet=$this->executerRequete($sql,array($output,$etat,$id,'P')) ; 
}

public function relancer($id_task)
{
  $sqlUpdate='update taches set etat = ?,res_exec = ? where id = ? ' ;
  $etat1 = "A" ;
  $this->executerRequete($sqlUpdate,array($etat1,"",$id_task)) ;
}

//uniquement pour l'admin
public function SuppressionPartage($id)
{
           $demande=$this->searchDemande_Admin($id) ; 
            if($demande != 0 )
             {
              $sqlUpdateDemande ='update demandes set etat=?,type=? where id = ? and (etat = ? OR etat= ? or etat=?)' ;
              $this->executerRequete($sqlUpdateDemande, array("A","S", $id,"T","R","E"));
              $this->filltasks($id,"S");
             }
              
}

//uniquement pour l'admin
public function creerPartage($nomPartage,$quota,$nomServ,$nomDisque,$listPersonnelsAvecLeursPermissions=null) 
{

     $sql= 'insert into demandes(nomPartage,quota,nomServ,nomDisque,etat,demandeur) values(?,?,?,?,?,?)'  ;     
     $demandeur=$this->getMatricule();
     $partage=new Partage() ;
     $nbr=$partage->searchIfShareExist($nomServ,$nomPartage) ;
    
   if($nbr == 0)
    {
     $this->executerRequete($sql, array($nomPartage,$quota,$nomServ,$nomDisque,"A",$demandeur)); 
     $id=$this->getLastIndex() ;
     if($listPersonnelsAvecLeursPermissions!=null){
     $this->insertCollaborators($id,$listPersonnelsAvecLeursPermissions) ;
      }
      $this->filltasks($id,"C");
    }
    else
    {
      //echo "exist" ;
    }
        
}


//uniquement pour l'admin
public function editPartage($id_demande,$nomPartage,$quota,$users=null,$permissions=null)
{
   
   
       $demande=$this->searchDemande($id_demande) ;
       if($demande['etat'] == "T" or $demande['etat'] == "R" or $demande['etat']=="E" )
       {
        $sqlUpdateDemande ='update demandes set nomPartage=?,etat=?,quota=?,type=? where id = ? and (etat = ? or etat = ? or etat=?)';
       $this->executerRequete($sqlUpdateDemande, array($nomPartage,"A",$quota,"M",$id_demande,"T","R","E"));
            if($users!=null and $permissions!=null)
            {
              $this->deleteCollaborators($id_demande) ; 
               $i=0 ;
            foreach ($users as $user) 
            {
              $this->insertNewCollaborator($id_demande,$user,$permissions[$i])  ;
              $i=$i+1 ;
            }
            }
             
           $this->filltasks($id_demande,"M");    
       }
       else
       {
          
       // echo "Vous ne pouvez pas éditer ce partage jusqu'à ce que l'administrateur l'approuve</br>";
       
       }
   
} 
    public function editoldPartage($nomServ,$nomDisque,$demandeur,$nomPartage,$quota,$users=null,$permissions=null)
{
        $sqlcreateDemande ="INSERT INTO demandes(nomServ, nomDisque, nomPartage, etat,quota, demandeur, type) VALUES (?,?,?,?,?,?,?)";
        $this->executerRequete($sqlcreateDemande,array($nomServ,$nomDisque,$nomPartage,"A",$quota,$demandeur,"M"));
        $id_demande=$this->getLastIndex() ;
        $sqlupdatepartage ='update partages set id_demande=?,quota=?,demandeur=? where nomserv=? and nompartage=?';
        $this->executerRequete($sqlupdatepartage,array($id_demande,$quota,$demandeur,$nomServ,$nomPartage));
            if($users!=null and $permissions!=null)
            {
               $i=0 ;
            foreach ($users as $user) 
            {
              $this->insertNewCollaborator($id_demande,$user,$permissions[$i])  ;
              $i=$i+1 ;
            }
            }
             
           $this->filltasks($id_demande,"M");  
        
   
            
}
        public function deleteoldPartage($nomServ,$nomDisque,$demandeur,$nomPartage)
{
        $quota=0;
        $sqlcreateDemande ="INSERT INTO demandes(nomServ, nomDisque, nomPartage, etat,quota, demandeur, type) VALUES (?,?,?,?,?,?,?)";
        $this->executerRequete($sqlcreateDemande,array($nomServ,$nomDisque,$nomPartage,"A","$quota",$demandeur,"S"));
        $id_demande=$this->getLastIndex() ;
        $sqlupdatepartage ='update partages set id_demande=?,quota=?,demandeur=? where nomserv=? and nompartage=?';
        $this->executerRequete($sqlupdatepartage,array($id_demande,$quota,$demandeur,$nomServ,$nomPartage));
        $this->filltasks($id_demande,"S");
}
}

?>