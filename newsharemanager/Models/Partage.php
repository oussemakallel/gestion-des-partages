<?php

spl_autoload_register(function ($class) {
    include $class . '.php';
});

Class Partage extends Modele {

    private $id;
    private $id_demande;
    private $nomPartage;
    private $quota;
    private $tailleActuel;
    private $adressReseau;
    private $cheminLocal;
    private $etatPartage;
    private $serveur;
    private $demandeur;
    private $disque;
    private $listCollaborateursAvecLeurPermission = array();
    private $maPermission;

    //function __construct($nomPartage, $quota,$adressReseau,$cheminLocal,$etatPartage,$tailleActuel = 0 )
   
    //function __construct($nomPartage, $quota,$adressReseau,$cheminLocal,$etatPartage,$tailleActuel = 0 )
    public function __construct()
    {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 0:
                break;
                case 4:
                $this->nomPartage   = $args[0];             
                $this->cheminLocal  = $args[1]  ;
                $this->tailleActuel = $args[2] ;
                $this->serveur= $args[3];
               // $this->etatPartage  = $args[4]  ;
                break ;    
                case 5:
                $this->nomPartage   = $args[0];
                $this->quota        = $args[1];
                $this->adressReseau = $args[2];
                $this->cheminLocal  = $args[3]  ;
              //  $this->etatPartage  = $args[4]  ;
                $this->tailleActuel = $args[4] ;
                break;
                default:
                break;
            }
    }
   
    /*  public function __construct($nomPartage, $quota,$adressReseau,$cheminLocal,$etatPartage,$tailleActuel = 0 )
      {
      $this->nomPartage = $nomPartage;
      $this->quota = $quota;
      $this->adressReseau = $adressReseau;
      $this->cheminLocal  = $cheminLocal  ;
      $this->etatPartage  = $etatPartage  ;
      $this->tailleActuel =$tailleActuel ;
      } */

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId_demande() {
        return $this->id_demande;
    }

    public function setId_demande($id_demande) {
        $this->id_demande = $id_demande;
        return $this;
    }

    public function getNomPartage() {
        return $this->nomPartage;
    }

    public function setNomPartage($nomPartage) {
        $this->nomPartage = $nomPartage;
        return $this;
    }

    public function getQuota() {
        return $this->quota;
    }

    public function setQuota($quota) {
        $this->quota = $quota;
        return $this;
    }

    public function getAdressReseau() {
        return $this->adressReseau;
    }

    public function setAdressReseau($adressReseau) {
        $this->adressReseau = $adressReseau;
        return $this;
    }

    public function getCheminLocal() {
        return $this->cheminLocal;
    }

    public function setCheminLocal($cheminLocal) {
        $this->cheminLocal = $cheminLocal;
        return $this;
    }

    public function getEtatPartage() {
        return $this->etatPartage;
    }

    public function setEtatPartage($etatPartage) {
        $this->etatPartage = $etatPartage;
        return $this;
    }

    public function getServeur() {
        return $this->serveur;
    }

    public function setServeur($serveur) {
        $this->serveur = $serveur;
        return $this;
    }

    public function getDemandeur() {
        return $this->demandeur;
    }

    public function setDemandeur($demandeur) {
        $this->demandeur = $demandeur;
        return $this;
    }

    public function getDisque() {
        return $this->disque;
    }

    public function setDisque($disque) {
        $this->disque = $disque;
        return $this;
    }

    public function getListCollaborateursAvecLeurPermission() {
        return $this->listCollaborateursAvecLeurPermission;
    }

    public function setListCollaborateursAvecLeurPermission($listCollaborateursAvecLeurPermission) {
        $this->listCollaborateursAvecLeurPermission = $listCollaborateursAvecLeurPermission;
        return $this;
    }

    public function getTailleActuel() {
        return $this->tailleActuel;
    }

    public function setTailleActuel($tailleActuel) {
        $this->tailleActuel = $tailleActuel;
        return $this;
    }

    public function getMaPermission() {
        return $this->maPermission;
    }

    public function setMaPermission($maPermission) {
        $this->maPermission = $maPermission;
        return $this;
    }

    public function getEtatById($id_demande) {
        $sql = 'select * from demandes where id = ?';
        $result = $this->executerRequete($sql, array($id_demande));
        foreach ($result as $d) {
            return $d['etat'];
        }
    }

    public function getNomById($id_demande) {
        $sql = 'select * from partages where id_demande = ?';
        $result = $this->executerRequete($sql, array($id_demande));
        foreach ($result as $d) {
            return $d['nomPartage'];
        }
    }

    public function getTypeById($id_demande) {
        $sql = 'select * from demandes where id = ?';
        $result = $this->executerRequete($sql, array($id_demande));
        foreach ($result as $d) {
            return $d['type'];
        }
    }

    public function searchIfShareExist($nomServ, $nomPartage) {

        $sqlSearchPartages = 'select * from partages where id_demande in (select id from demandes where nomPartage=? and nomServ=? and not(etat=? and type=?))';
        $resultSetPartages = $this->executerRequete($sqlSearchPartages, array($nomPartage, $nomServ,'T','S'));
        $rowcountResultSetPartages = $resultSetPartages->rowCount();
        
        $sqlSearchPartagesancien = 'select * from partages where id_demande=0 and nomPartage=? and nomServ=?';
        $resultSetPartagesancien = $this->executerRequete($sqlSearchPartagesancien, array($nomPartage, $nomServ));
        $rowcountResultSetPartagesancien = $resultSetPartagesancien->rowCount();

        return $rowcountResultSetPartages + $rowcountResultSetPartagesancien ;
    }

//Renvoie liste de partages d'un personnel
    public function getPartages($matricule) {
        $listPersonnelPartages = array();
        $listPartagesP = null;
        $sql = 'select * from partages where id in (select DISTINCT id_partage from partagepermission where utilisateur=?)';
        $listPartages = $this->executerRequete($sql, array($matricule));
        if ($listPartages->rowCount() != 0) {
            echo 'exist';
            $i = 0;
            foreach ($listPartages as $partage) {
                $objpartage = new Partage();
                $objpartage->maPermission = $this->getPermission($matricule, $partage['id']);
                $listPersonnelPartages[$i] = $objpartage->getPartageById($partage['id']);
                $i = $i + 1;
            }
        }

        return $listPersonnelPartages;
    }

//Renvoie un partage   //mapping
    public function getPartage($nomPartage, $nomServ) {
        $partages = null;
        $sql = 'select * from partages where nomPartage=? and nomServ=?';
        $partages = $this->executerRequete($sql, array($nomPartage, $nomServ));
        if ($partages != null and count($partages) == 1) {
            foreach ($partages as $partage) {
                $this->id = $partage['id'];
                $this->id_demande = $partage['id_demande'];
                $this->nomPartage = $partage['nomPartage'];
                $this->quota = $partage['quota'];
                $this->tailleActuel = $partage['tailleActuel'];
                $this->adressReseau = $partage['adressReseau'];
                $this->cheminLocal = $partage['cheminLocal'];
                $this->etatPartage = $partage['etat'];
                $this->listCollaborateursAvecLeurPermission = $this->listerCollaborateurs($partage['id']);
                $this->serveur = (new Serveur())->mappingServ($nomServ);
                //if ($partage['demandeur'] != "") {
                    $this->demandeur = (new Personnel())->getActiveUser($partage['demandeur']);
                //} else {
                //    $this->demandeur = "";
                //}
                $this->disque = (new Disque())->getDisque($this->serveur->getId(), $partage['disque']);
            }
        }
        return $this;
    }

//non 
    public function consultAllShares() {
        $sql = 'select * from partages';
        $resultSet = $this->executerRequete($sql);
        $partages = array();
        foreach ($resultSet as $partage) {
            $p = new Partage();
            $p->getPartageById($partage['id']);
            $partages[] = $p;
        }
        return $partages;
    }

    public function getPartageById($id_partage) {
        $partages = null;
        $sql = 'select * from partages where id = ?';
        $partages = $this->executerRequete($sql, array($id_partage));
        if ($partages->rowCount() != 0) {
            foreach ($partages as $partage) {
                $this->id = $partage['id'];
                $this->id_demande = $partage['id_demande'];
                $this->nomPartage = $partage['nomPartage'];
                $this->quota = $partage['quota'];
                $this->tailleActuel = $partage['tailleActuel'];
                $this->adressReseau = $partage['adressReseau'];
                $this->cheminLocal = $partage['cheminLocal'];
                $this->etatPartage = $partage['etat'];
                $this->listCollaborateursAvecLeurPermission = $this->listerCollaborateurs($partage['id']);
                $this->serveur = (new Serveur())->mappingServ($partage['nomServ']);

                if ($partage['demandeur'] != "None") {

                    $this->demandeur = (new Personnel())->getActiveUser($partage['demandeur']);
                } else {

                    $this->demandeur = new Personnel();
                }


                $this->disque = (new Disque())->getDisque($this->serveur->getId(), $partage['disque']);
            }
        }
        return $this;
    }

//Renvoie  une Liste de Collaborateurs d'un partage ou null  champs :: matricule :: permission
    public function listerCollaborateurs($id_Partage) {
        $listeCollaborateurs = null;
        $sql = 'select * from partagepermission where id_partage=?';
        $listeCollaborateurs = $this->executerRequete($sql, array($id_Partage));
        $listColl = null;

        if ($listeCollaborateurs != null) {
            $listColl = array();
            $i = 0;
            foreach ($listeCollaborateurs as $collaborateur) {
                $user = new Personnel();
                $listColl[$i] = new Permission($user->getActiveUser($collaborateur['utilisateur']), $collaborateur['permission']);
                $i = $i + 1;
            }
        }

        return $listColl;
    }

//renvoie permission d'un personnel sur un paratge
    public function getPermission($matricule, $id_Partage) {
        $p = null;
        $permissions = null;
        $sql = 'select permission from partagepermission where id_partage=? and utilisateur=?';
        $permissions = $this->executerRequete($sql, array($id_Partage, $matricule));
        if ($permissions != null and count($permissions) == 1) {
            foreach ($permissions as $permission) {
                $p = $permission['permission'];
            }
        }
        return $p;
    }
    public function deleteShareFromAllTable($nomPartage,$nomServ,$id)
{
  $id_demande = 0  ;
  $sqlDeleteP  ='delete  from partages where nomPartage = ? and nomServ = ?' ;
  $sqlDeletePP ='delete  from partagepermission where id_partage = ? ' ;
  $sqlDeleteD  = 'delete  from demandes where nomPartage = ? and nomServ = ?' ;
  $sqlDeleteDP = 'delete from demandespermission where id_demande = ?' ;
  $sql = 'select * from demandes where nomPartage = ? and nomServ = ?' ;
  $resultSet=$this->executerRequete($sql , array($nomPartage,$nomServ))  ; 
   $this->executerRequete($sqlDeleteP , array($nomPartage,$nomServ))  ; 
   $this->executerRequete($sqlDeletePP , array($id))  ;

   if ($resultSet->rowCount()!=0) {
      foreach ($resultSet as $demande)
    {    
     $id_demande = $demande['id'] ;
    }
    $this->executerRequete($sqlDeleteD , array($nomPartage,$nomServ))  ;   
    $this->executerRequete($sqlDeleteDP , array($id_demande))  ;
   }
  
  
  }


//delete all shares that do not exist in the local area network
public function deleteShareFromVBS($list)
{
  $sql= 'select * from partages where nomServ = ?' ;
  $resultSet = $this->executerRequete($sql,array($list[0]->getServeur()))  ;
  foreach ($resultSet as $partage) {
           $i=0 ;
           $verif = true ;     
            while ( $i < sizeof($list) and $verif )
            {
              if($partage['nomPartage'] == $list[$i]->getNomPartage()  and $partage['nomServ'] ==$list[$i]->getServeur() )
              {
                $verif = false ;
              }          
              $i=$i+1;       
            }
            if ($verif) 
            {
              $this->deleteShareFromAllTable($partage['nomPartage'],$partage['nomServ'],$partage['id']) ;
            }
              

      }
   
  }

public function getPartageByIdPartage($id_partage)
{
  $sql = 'select * from partages where id = ?';
  $partages = $this->executerRequete($sql, array($id_partage));
  return $partages ;
}



public function deleteCollabFromParatge($nomPartage,$nomServ,$matricule)
{
  $sql= 'select * from partages where nomPartage= ? and nomServ=?' ;
  $resultSet=$this->executerRequete($sql,array($nomPartage,$nomServ));
  foreach ($resultSet as $p) 
  {
     $id_Partage=$p['id'] ;   
  }
   $sqlDelete='delete from partagepermission where id_Partage = ? and utilisateur = ?';
   $this->executerRequete($sqlDelete,array($id_Partage,$matricule)) ;
}

public function deleteCollab($list)
{
  
  $sqlSearchCollab='select * from partagepermission' ;
  $collabs=$this->executerRequete($sqlSearchCollab) ; 


  foreach ($collabs as $c) 
  {
        
   
          $res= $this->getPartageByIdPartage($c['id_partage']) ;
                      foreach ($res as $p) 
                      {
                        $nompartage=$p['nomPartage'];
                        $serv = $p['nomServ'];
                      }
              $i=0 ;
              $v="ok" ; 
            while ( $i < sizeof($list) and $v == "ok")
            {
               $verif = true ; 
               if ( $serv==$list[$i]->getServeur() and $nompartage==$list[$i]->getNomPartage()) 
               {
                   foreach ($list[$i]->getListCollaborateursAvecLeurPermission()  as $collab ) 
                   {
                          if($c['utilisateur'] ==$collab->getPersonnel()   )
                            {
                              $verif = false ;
                            }  
                   }  
                       
               }

               if ($verif == true and $serv==$list[$i]->getServeur() and $nompartage==$list[$i]->getNomPartage() ) 
               {
                   $this->deleteCollabFromParatge($list[$i]->getNomPartage(),$list[$i]->getServeur() ,$c['utilisateur']) ;
                    $v= "exit" ;

               }
                            
              $i=$i+1;       
            }

           





  }
}

public function insertShare($list)
{

//var $etat,$type,$quota,$row_countP,$id_Partage_Permission ;

    foreach($list as $partage )
    {
      $sqlSearchPartage =  'select * from partages where nomPartage=? and nomServ=?' ;
      $sqlSearchPartageByIdDemande =  'select * from partages where  id_demande = ?' ;
      $sqlSearchDemande =  'select * from demandes where nomPartage=? and nomServ=? '  ;
      $sqlSearchDemandeByIdDemande= 'select * from demandes where id=? '  ;
      $demandes = $this->executerRequete($sqlSearchDemande , array($partage->getNomPartage(),$partage->getServeur()));
      $row_countD =  $demandes->rowCount(); 

   if ( $row_countD != 0) 
      { 
            foreach ($demandes as $d) 
             {
              $id_demande=$d['id'] ;   
              $etat=$d['etat'];
              $type=$d['type'] ;     
              $quota=$d['quota'] ;
              $demandeur=$d['demandeur'];
             }
              $partages = $this->executerRequete( $sqlSearchPartageByIdDemande , array($id_demande));
              $row_countP = $partages->rowCount();


                     
               if ($row_countP != 0)
                {
                      if($type=="M" and $etat=="T")
                        {
                      $sqlUpdateP='update partages set nomPartage=? ,quota=? ,tailleActuel=? where id_demande = ?' ;
                      $this->executerRequete( $sqlUpdateP, array($partage->getNomPartage(),$quota,$partage->getTailleActuel(),$id_demande));
                       }
                       else
                       {
                        $sqlUpdateP='update partages set nomPartage=?,tailleActuel=? where id_demande = ?' ;
                        $this->executerRequete( $sqlUpdateP, array($partage->getNomPartage(),$partage->getTailleActuel(),$id_demande));
                     } 
                      foreach ($partages as $p) 
                             {
                               $id_partage=$p['id'] ;
                             }
                     foreach ($partage->getListCollaborateursAvecLeurPermission() as $c) 
                                  {
                                         $resultSet=$this->searchUserByFromPartagePermission($id_partage,$c->getPersonnel()) ;
                                          if ($resultSet->rowCount()==0) 
                                            {
                                               $sqlInsert = 'insert into partagepermission(id_partage,utilisateur,permission) values(?,?,?)' ;
                                               $this->executerRequete($sqlInsert ,array($id_partage,$c->getPersonnel(),$c->getPermission())) ;
                                            }
                                            else
                                            {
                                              foreach ($resultSet as $p) 
                                              {
                                                 $id_Partage_Permission = $p['id'] ;
                                              }
                                              $sqlUpdateP='update partagepermission set permission=? where id = ?' ;
                                              $this->executerRequete( $sqlUpdateP, array($c->getPermission(),$id_Partage_Permission));
                                            }
                        /*collaborateur*/
                                  }  
                     

                }
               else
               {
                        if($type=="C" and $etat=="T")
                        {
                          $sqlInsertP='insert into partages(id_demande,nomPartage,quota,adressReseau,cheminLocal,tailleActuel,nomServ,demandeur,disque) values(?,?,?,?,?,?,?,?,?)' ;
                          $this->executerRequete( $sqlInsertP, array($id_demande,$partage->getNomPartage(),$quota,'\\\\'.$partage->getServeur().'\\'.$partage->getNomPartage(),$partage->getCheminLocal(),$partage->getTailleActuel(),$partage->getServeur(),$demandeur,substr($partage->getCheminLocal(),0,2)));
                              $id=$this->getLastIndex() ;
                              foreach ($partage->getListCollaborateursAvecLeurPermission() as $c) 
                                  {        
                                               $sqlInsert = 'insert into partagepermission(id_partage,utilisateur,permission) values(?,?,?)' ;
                                               $this->executerRequete($sqlInsert ,array($id,$c->getPersonnel(),$c->getPermission())) ;                  
                                  }
                        }
                     
               }
                             
      }
      else
      {
                    $partages = $this->executerRequete( $sqlSearchPartage , array($partage->getNomPartage(),$partage->getServeur()));
                    $row_countP = $partages->rowCount();
                    
                    if ($row_countP != 0)
                    {

                          foreach ($partages as $p)
                           {
                            $id_demande = $p['id_demande'] ;
                            $id_partage=$p['id'] ;
                           }

                        if($id_demande == 0)
                        {
                          /*----------------------------------------------------------*/
                          $sqlUpdateP='update partages set tailleActuel=? where nomPartage=? and nomServ=? ' ;
                          $this->executerRequete( $sqlUpdateP, array($partage->getTailleActuel(),$partage->getNomPartage(),$partage->getServeur()));
                           foreach ($partage->getListCollaborateursAvecLeurPermission() as $c) 
                                  {
                                         $resultSet=$this->searchUserByFromPartagePermission($id_partage,$c->getPersonnel()) ;
                                          if ($resultSet->rowCount()==0) 
                                            {
                                               $sqlInsert = 'insert into partagepermission(id_partage,utilisateur,permission) values(?,?,?)' ;
                                               $this->executerRequete($sqlInsert ,array($id_partage,$c->getPersonnel(),$c->getPermission())) ;
                                            }
                                            else
                                            {
                                              foreach ($resultSet as $p) 
                                              {
                                                 $id_Partage_Permission = $p['id'] ;
                                              }
                                              $sqlUpdateP='update partagepermission set permission=? where id = ?' ;
                                              $this->executerRequete( $sqlUpdateP, array($c->getPermission(),$id_Partage_Permission));
                                            }
                        /*collaborateur*/
                                  }




                        }
                        else
                        {
                          $sqlUpdateP='update partages set tailleActuel=? where id_demande=? ' ;
                          $this->executerRequete( $sqlUpdateP, array($partage->getTailleActuel(),$id_demande));
                           foreach ($partage->getListCollaborateursAvecLeurPermission() as $c) 
                                  {
                                         $resultSet=$this->searchUserByFromPartagePermission($id_partage,$c->getPersonnel()) ;
                                          if ($resultSet->rowCount()==0) 
                                            {
                                               $sqlInsert = 'insert into partagepermission(id_partage,utilisateur,permission) values(?,?,?)' ;
                                               $this->executerRequete($sqlInsert ,array($id_partage,$c->getPersonnel(),$c->getPermission())) ;
                                            }
                                            else
                                            {
                                              foreach ($resultSet as $p) 
                                              {
                                                 $id_Partage_Permission = $p['id'] ;
                                              }
                                              $sqlUpdateP='update partagepermission set permission=? where id = ?' ;
                                              $this->executerRequete( $sqlUpdateP, array($c->getPermission(),$id_Partage_Permission));
                                            }
                        /*collaborateur*/
                                  }
                        }
                      
                    
               
                }
                else
                {
                  $sqlInsertP='insert into partages(nomPartage,quota,adressReseau,cheminLocal,tailleActuel,nomServ,disque) values(?,?,?,?,?,?,?)' ;
                          $this->executerRequete( $sqlInsertP, array($partage->getNomPartage(),0,'\\\\'.$partage->getServeur().'\\'.$partage->getNomPartage(),$partage->getCheminLocal(),$partage->getTailleActuel(),$partage->getServeur(),substr($partage->getCheminLocal(),0,2))); 
                          $id=$this->getLastIndex() ;
                          foreach ($partage->getListCollaborateursAvecLeurPermission() as $c) 
                                  {        
                                               $sqlInsert = 'insert into partagepermission(id_partage,utilisateur,permission) values(?,?,?)' ;
                                               $this->executerRequete($sqlInsert ,array($id,$c->getPersonnel(),$c->getPermission())) ;                  
                                  }
                }
                       
      }
      
  }
}


public function searchUserByFromPartagePermission($id_partage,$matricule)
{
  $sqlSelect = 'select * from partagepermission where id_partage = ? and utilisateur = ?' ;
  $resultSet=$this->executerRequete($sqlSelect,array($id_partage,$matricule)) ;
  return $resultSet ;
}

}
 ?>