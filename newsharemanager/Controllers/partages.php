<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
//init buttons
$prefix = '';
$suffix = '';
$collab = '<button  class="btn btn-default" data-toggle="modal" data-target="#sharecollab"><span class="glyphicon glyphicon-user" ></span> Visualiser</button>';

$action = 'Indisponible';

$modifsupp = '<div class="btn-group"><button class="btn btn-warning" data-toggle="modal" data-target="#editshareadminform"><span class="glyphicon glyphicon-edit"></span>  Modifier</button><button  style="margin-left:10px;" class="btn btn-danger" onclick="deleteshare();" ><span class="glyphicon glyphicon-remove" ></span>  Supprimer</button></div>';

$modifsuppuser = '<div class="btn-group"><button class="btn btn-warning" data-toggle="modal" data-target="#editshareuserform"><span class="glyphicon glyphicon-edit"></span>  Modifier</button><button  style="margin-left:10px;" class="btn btn-danger" onclick="deleterequest();" ><span class="glyphicon glyphicon-remove" ></span>  Supprimer</button></div>';

$modifsuppold='<div class="btn-group"><button class="btn btn-warning" data-toggle="modal" data-target="#editoldsharemodal"><span class="glyphicon glyphicon-edit"></span>  Modifier</button><button  style="margin-left:10px;" class="btn btn-danger" onclick="deleteoldshare();" ><span class="glyphicon glyphicon-remove" ></span>  Supprimer</button></div>';

$block = '<div class="btn-group"><button class="btn btn-danger" onclick="blocker();" ><span class="glyphicon glyphicon-minus-sign"  ></span> Bloquer</button></div>';
$result['data'] = array();
$u = new Personnel();
$user = $u->getActiveUser($_SESSION['matricule']);
$d = strtoupper($user->getDroit());
if ($d == "ADMIN") {
    ob_start();
    $partages = $user->consultAllShares();
    ob_end_clean();
    foreach ($partages as $p) {
        if ($p->getId_demande() == 0)
            $result['data'][] = array(
                $p->getId(),
                $p->getId_demande(),
                $p->getAdressReseau(),
                $p->getServeur()->getNomServ(),
                $p->getDisque()->getNomDisque(),
                $p->getTailleActuel(),
                $p->getQuota(),
                $collab,
                'Actif',
                $modifsuppold,
                $p->getNomPartage());
        else {
            if (!($p->getTypeById($p->getId_demande()) == 'S' and $p->getEtatById($p->
                getId_demande()) == 'T' ) ){
                $act = $modifsupp;
                $state = 'Actif';
                if ($p->getTypeById($p->getId_demande()) == 'M' and $p->getEtatById($p->
                    getId_demande()) == 'N')
                    $act = 'demande de Modification';
                if ($p->getTypeById($p->getId_demande()) == 'M' and $p->getEtatById($p->
                    getId_demande()) == 'A')
                    $act = 'Modification en cours';
                if ($p->getTypeById($p->getId_demande()) == 'S' and $p->getEtatById($p->
                    getId_demande()) == 'N')
                    $act = 'demande de Suppression';
                if ($p->getTypeById($p->getId_demande()) == 'S' and ($p->getEtatById($p->
                    getId_demande()) =='A'))
                    $act = 'Suppression en cours';
                if ($p->getQuota() < $p->getTailleActuel()) {
                    $state = 'Quota dépassée';
                    $act = $block;
                }
                $result['data'][] = array(
                    $p->getId(),
                    $p->getId_demande(),
                    $p->getAdressReseau(),
                    $p->getServeur()->getNomServ(),
                    $p->getDisque()->getNomDisque(),
                    $p->getTailleActuel(),
                    $p->getQuota(),
                    $collab,
                    $state,
                    $act,
                    $p->getNomPartage());
            }
            }
        }

    }
 elseif ($d == "UTILISATEUR") {
    ob_start();
    $partages = $user->consulterLaListeDesPartages();
    ob_end_clean();
    foreach ($partages as $p) {
        if ($p->getId_demande() == 0)
            $result['data'][] = array(
                $p->getId(),
                'None',
                $p->getAdressReseau(),
                $p->getServeur()->getNomServ(),
                $p->getDisque()->getNomDisque(),
                $p->getTailleActuel(),
                $p->getQuota(),
                $collab,
                'Actif',
                'Indisponible',
                $p->getNomPartage());
        else {
            if (!($p->getTypeById($p->getId_demande()) == 'S' and $p->getEtatById($p->
                getId_demande()) == 'T')) {
                if ($p->getDemandeur() == $_SESSION['matricule'])
                    $act = $modifsuppuser;
                else
                    $act = 'Pas d\'action';
                $state = 'Actif';
                if ($p->getTypeById($p->getId_demande()) == 'M' and $p->getEtatById($p->
                    getId_demande()) == 'N')
                    $act = 'demande de Modification';
               if ($p->getTypeById($p->getId_demande()) == 'M' and ($p->getEtatById($p->
                    getId_demande()) == 'A' or $p->getEtatById($p->
                    getId_demande()) == 'E'))
                   $act = 'Modification en cours';
                if ($p->getTypeById($p->getId_demande()) == 'S' and $p->getEtatById($p->
                    getId_demande()) == 'N')
                    $act = 'demande de Suppression';
                if ($p->getTypeById($p->getId_demande()) == 'S' and ($p->getEtatById($p->
                    getId_demande()) == 'A' or $p->getEtatById($p->
                    getId_demande()) == 'E'))
                    $act = 'Suppression en cours';
                if ($p->getQuota() < $p->getTailleActuel()) {
                    $state = 'Quota dépassée';
                    $act = $block;
                }
                $result['data'][] = array(
                    $p->getId(),
                    $p->getId_demande(),
                    $p->getAdressReseau(),
                    $p->getServeur()->getNomServ(),
                    $p->getDisque()->getNomDisque(),
                    $p->getTailleActuel(),
                    $p->getQuota(),
                    $collab,
                    $state,
                    $act,
                    $p->getNomPartage());
            }
        }

    }
} else {
    if(isset($_GET['matcollab'])){
    ob_start();
    $partage=New Partage();
    $partages = $partage->getPartages($_GET['matcollab']);
    ob_end_clean();

    foreach ($partages as $p) {
         $result['data'][] = array(
                    $p->getId(),
                    $p->getAdressReseau(),
                    $p->getServeur()->getNomServ(),
                    $p->getDisque()->getNomDisque(),
                    $p->getTailleActuel(),
                    $p->getQuota(),
                    $collab,
                    'Actif'
         );
    
    
    }
        }
    
}



echo json_encode($result);







?>