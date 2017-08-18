<?php

spl_autoload_register(function ($class) {
    include $class . '.php';
});

Class Personnel extends Modele {

    protected $matricule;
    protected $nom;
    protected $prenom;
    protected $droit;

    public function __construct() {
        $ctp = func_num_args();
        $args = func_get_args();
        switch ($ctp) {
            case 0:
                break;
            case 1:
                $this->matricule = $args[0];
                break;
            case 4:
                $this->matricule = $args[0];
                $this->nom = $args[1];
                $this->prenom = $args[2];
                $this->droit = $args[3];
                break;
            default:
                break;
        }
    }

    public function getMatricule() {
        return $this->matricule;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getDroit() {
        return $this->droit;
    }

    public function setMatricule($matricule) {
        $this->matricule = $matricule;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setDroit($droit) {
        $this->droit = $droit;
    }

    public function __toString() {
        return "Matricule :  $this->matricule </br>" . "Nom :: $this->nom </br> Prenom :: $this->prenom </br> Droit :: $this->droit </br>";
    }

 // Renvoie  un personnel approprié ou null 
    public function getActiveUser($matricule) {
        $personnel = null;
        $ADProp = $this->SetNomDepartementAD($matricule);
        $sql = 'select * from personnels where matricule=?';
        $personnel = $this->executerRequete($sql, array($matricule));
        if ($personnel->rowCount() != 0) {
            $personnel = $this->mapping($personnel);
           // echo(print_r($personnel,TRUE));
        }
        else{
            $personnel =  new Utilisateur($matricule, $ADProp['nom'], $ADProp['prenom']);
        }
        $cfg = new Config();
        $cfg->errlogtxt("Authentification    : ".$matricule);
        $cfg->errlogtxt(print_r($personnel,true));
        return $personnel;
    }

// retourner un personnel approprié
    public function mapping($resultSet) {
        foreach ($resultSet as $personnel) {
            $ADProp = $this->SetNomDepartementAD($personnel['matricule']);
            switch ($personnel['droit']) {
                case "Technicien":
                    return new Technicien($personnel['matricule'], $ADProp['nom'], $ADProp['prenom']);
                    break;
                case "Admin":
                    return new Administrateur($personnel['matricule'], $ADProp['nom'], $ADProp['prenom']);
                    break;
                default:
                    return new Utilisateur($personnel['matricule'], $ADProp['nom'], $ADProp['prenom']);
            }
        }
    }
    
    function SetNomDepartementAD($matricule) {
        $cfg = new config();
        $retour = array();
        $retour['prenom'] = "testprenom";
        $retour['nom'] = "testnom";
        /*$ldapconn = ldap_connect($cfg->getLdapHost(), $cfg->getLdapPort());
        if ($ldapconn) {
            $ldapbind = ldap_bind($ldapconn, $cfg->getLdapRdn(), $cfg->getLdapPass());
            $justthese = array("givenName", "sn");
            if ($ldapbind) {
                $sr = ldap_search($ldapconn, $cfg->getLdapBaseDN(), "(&(samaccountname=" . $matricule . "))", $justthese);
                $info = ldap_get_entries($ldapconn, $sr);
                
                for ($i = 0; $i < $info["count"]; $i++) {
                    //echo(print_r($info[$i]));
                    $retour['prenom'] = $info[$i]["givenname"][0];
                    $retour['nom'] = $info[$i]["sn"][0];
                }
                ldap_unbind($ldapconn);
            }
        }*/
        return $retour;
        
    }

//Renvoie une liste de partages approprié à un personnel connecté
    public function consulterLaListeDesPartages() {
        $partage = new Partage();
        $partages = $partage->getPartages($this->matricule);
        return $partages;
    }

//Renvoie une liste de demandes
    public function consulterDemandes($type) {
        $demande = new Demande();
        $demandes = $demande->getDemandesByMatricule($this->getMatricule(), $type);
        return $demandes;
    }

    /* -------------------demande  creation partage------------------------------------- */

//demande  creation partage
    public function demandePartage($nomPartage, $quota, $listPersonnelsAvecLeursPermissions = null) {
        //$nbr=$this->searchDemandeByNomPartage($nomPartage) ;
        // if($nbr == 0)
        // {   
        $sql = 'insert into demandes(nomPartage,quota,demandeur) values(?,?,?)';
        $demandeur = $this->getMatricule();
        $this->executerRequete($sql, array($nomPartage, $quota, $demandeur));
        $id = $this->getLastIndex();
        if ($listPersonnelsAvecLeursPermissions != null) {
            $this->insertCollaborators($id, $listPersonnelsAvecLeursPermissions);
        }
        /* notification */
        $user = new Administrateur();
        $admins = $user->getAdministrators();
        foreach ($admins as $admin) {
            $sqlNotif = 'insert into notification (destinataire,message,type) values(?,?,?)';
            $this->executerRequete($sqlNotif, array($admin['matricule'], "demande creation :: " . $demandeur, "INFO"));
        }
        /* ------------------------------------ */

        /*  }
          else
          {
          // echo "existant row";
          } */
    }

//insert collaborators in demandesPermission Table 
//util  demandePartage
    public function insertCollaborators($id, $listPersonnelsAvecLeursPermissions) {
        $sqlInsert = 'insert into demandespermission(id_Demande,utilisateur,permission) values(?,?,?)';
        foreach ($listPersonnelsAvecLeursPermissions as $coll) {
            $this->executerRequete($sqlInsert, array($id, $coll->getPersonnel(), $coll->getPermission()));
        }
    }

    /* ------------------------------------------------------------------ */

//utilisateur : Can not change the share until it is created
    public function updateDemandePartage($id, $nomPartage, $quota) {
        $demande = $this->searchDemandeById($id);
        if ($nomPartage != "" and $quota != "" and $demande != 0) {
            $sqlUpdateDemande = 'update demandes set nomPartage=?,etat=?,quota=?,type=? where id = ? and (etat = ? or etat = ?)';
            $this->executerRequete($sqlUpdateDemande, array($nomPartage, "N", $quota, "M", $id, "T", "R"));
        }
    }

    public function updateDemandePartagewithoutchangetype($id, $nomPartage, $quota) {
        $demande = $this->searchDemandeById($id);
        if ($nomPartage != "" and $quota != "" and $demande != 0) {
            $sqlUpdateDemande = 'update demandes set nomPartage=?,etat=?,quota=? where id = ? and etat = ? ';
            $this->executerRequete($sqlUpdateDemande, array($nomPartage, "N", $quota, $id, "N"));
        }
    }

//utilisateur : Can not change the share until it is created
    public function updateDemandeQuota($id, $quota) {
        $demande = $this->searchDemandeById($id);

        if ($quota != "" and $demande != 0) {
            $sqlUpdateDemande = 'update demandes set etat=?,quota=?,type=?  where id = ? and (etat = ? or etat = ?)';
            $this->executerRequete($sqlUpdateDemande, array("N", $quota, "M", $id, "T", "R"));
        }
    }

//utilisateur : Can not change the share until it is created
    public function updateDemandeNameP($id, $nomPartage) {
        $demande = $this->searchDemandeById($id);

        if ($nomPartage != ""and $demande != 0) {
            $sqlUpdateDemande = 'update demandes set nomPartage=?,etat=?,type=? where id = ? and (etat = ? or etat = ?)';
            $this->executerRequete($sqlUpdateDemande, array($nomPartage, "N", "M", $id, "T", "R"));
        }
    }

//utilisateur : Can not change the share until it is created
    public function demandeDeSupprission($id) {
        $demande = $this->searchDemandeById($id);
        $d = $this->searchDemande($id);
        if ($this->getMatricule() == $d['demandeur']) {
            if ($demande != 0) {
                $sqlUpdateDemande = 'update demandes set etat=?,type=? where id = ? and (etat = ? or etat = ?)';
                $this->executerRequete($sqlUpdateDemande, array("N", "S", $id, "T", "R"));
                /* notification */
                if ($d['etat'] == "T" or $d['etat'] == "R") {
                    $user = new Administrateur();
                    $admins = $user->getAdministrators();
                    foreach ($admins as $admin) {
                        $sqlNotif = 'insert into notification (destinataire,message,type) values(?,?,?)';
                        $this->executerRequete($sqlNotif, array($admin['matricule'], "demande suppression :: " . $d['demandeur'], "INFO"));
                    }
                    /* ------------------------------------ */
                }
            }
        }
    }

    /* -----appeller cette fonction lorsque on click sur demander reservé au demandeur------------------ */

    public function editUserDemande($id_demande, $nomPartage, $quota, $users, $permissions) {
        if ($id_demande != "" and $nomPartage != "" and $quota != "" and $users != "" and
                $permissions) {
            $demande = $this->searchDemande($id_demande);
            if ($demande['etat'] == "T" or $demande['etat'] == "R") {
                $this->updateDemandePartage($id_demande, $nomPartage, $quota);
                $this->deleteCollaborators($id_demande);
                $i = 0;
                foreach ($users as $user) {
                    $this->insertNewCollaborator($id_demande, $user, $permissions[$i]);
                    $i = $i + 1;
                }

                /* notification */
                $user = new Administrateur();
                $admins = $user->getAdministrators();
                foreach ($admins as $admin) {
                    $sqlNotif = 'insert into notification (destinataire,message,type) values(?,?,?)';
                    $this->executerRequete($sqlNotif, array($admin['matricule'], "demande modification :: " . $demande['demandeur'], "INFO"));
                }
                /* ------------------------------------ */
            } else {

                // echo "Vous ne pouvez pas éditer ce partage jusqu'à ce que l'administrateur l'approuve</br>";
            }
        }
    }

    /* -----appeller cette fonction lorsque on click sur demander reservé au demandeur------------------ */

    public function editUserDemandeNaprroved($id_demande, $nomPartage, $quota, $users, $permissions) {
        if ($id_demande != "" and $nomPartage != "" and $quota != "" and $users != "" and
                $permissions) {
            $demande = $this->searchDemande($id_demande);
            if ($demande['etat'] == "N") {
                $this->updateDemandePartagewithoutchangetype($id_demande, $nomPartage, $quota);
                $this->deleteCollaborators($id_demande);
                $i = 0;
                foreach ($users as $user) {
                    $this->insertNewCollaborator($id_demande, $user, $permissions[$i]);
                    $i = $i + 1;
                }
            } else {

                // echo "Vous ne pouvez pas éditer ce partage jusqu'à ce que l'administrateur l'approuve</br>";
            }
        }
    }

    public function deleteUserDemandeNaprroved($id_demande) {
        if ($id_demande != '') {
            $demande = $this->searchDemande($id_demande);
            if ($demande['etat'] == "N" and $demande['type'] == 'C') {
                $this->deleteCollaborators($id_demande);
                $sql = 'delete from demandes where id = ? and etat = ? and type = ?';
                $this->executerRequete($sql, array($id_demande, "N", "C"));
            } else {

                // echo "Vous ne pouvez pas éditer ce partage jusqu'à ce que l'administrateur l'approuve</br>";
            }
        }
    }

//Remove collaborators from demandesPermission Table
//util pour editUserDemande
    public function deleteCollaborators($id_demande) {
        $sqlDelete = 'delete from demandespermission where id_demande = ?';
        $this->executerRequete($sqlDelete, array($id_demande));
    }

//insert new collaborator
//util pour editUserDemande
    public function insertNewCollaborator($id_demande, $utilisateur, $permission) {
        $sqlInsert = 'insert into demandespermission(id_Demande,utilisateur,permission) values(?,?,?)';
        $this->executerRequete($sqlInsert, array($id_demande, $utilisateur, $permission));
    }

    /* ----------------------------------------------------------------------------------- */

//unused
    public function envoyerReclamation($message) {
        $sql = 'insert into reclamations(utilisateur,message,dateReclam) values(?,?,?)';
        $date = date(DATE_W3C);
        $this->executerRequete($sql, array($this->getMatricule(), $message, $date));
    }

//utile dans les autres fonctions
    public function searchDemandeById($id) {
        $sql = 'select * from demandes where id = ?';
        $resultSet = $this->executerRequete($sql, array($id));
        return $resultSet->rowCount();
    }

//utile dans les autres fonctions
    public function searchDemande($id) {
        $sql = 'select * from demandes where id = ?';
        $resultSet = $this->executerRequete($sql, array($id));
        foreach ($resultSet as $demande) {
            return $demande;
        }
    }

//utile dans les autres fonctions
    public function searchDemandeByNomPartage($nomPartage) {
        $sql = 'select * from demandes where nomPartage = ? and demandeur = ?';
        $resultSet = $this->executerRequete($sql, array($nomPartage, $this->getMatricule()));
        return $resultSet->rowCount();
    }

    public function searchCollByIdDemandePermission($id) {
        $sql = 'select * from demandespermission where id = ?';
        $resultSet = $this->executerRequete($sql, array($id));
        foreach ($resultSet as $coll) {
            return $coll;
        }
    }

//utile dans les autres fonctions 
    public function updateDemandeNotApproved($id) {
        $sqlUpdateDemande = 'update demandes set etat=? where id = ?';
        $this->executerRequete($sqlUpdateDemande, array("N", $id));
    }

}

?>