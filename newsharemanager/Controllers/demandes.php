<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();

if (isset($_GET['type']))
    $type = strtoupper($_GET['type']);

//init buttons
$collab = '<button  class="btn btn-default" data-toggle="modal" data-target="#requestcollab"><span class="glyphicon glyphicon-user" ></span> Visualiser</button>';

$approve = '<button  class="btn btn-sm btn-success" data-toggle="modal" data-target="#adminacceptform"><span class="glyphicon glyphicon-ok"></span></button><button  style="margin-left:10px;" class="btn btn-danger" onclick="refuserdemande();"><span class="glyphicon glyphicon-remove" ></span></button>';

$approvemodif = '<button  class="btn btn-sm btn-success" data-toggle="modal" data-target="#adminacceptmodifform"><span class="glyphicon glyphicon-ok"></span></button><button  style="margin-left:10px;" class="btn btn-danger" onclick="refuserdemande();"><span class="glyphicon glyphicon-remove" ></span></button>';

$approvesupp = '<button  class="btn btn-sm btn-success" onclick="confirmdelete();"><span class="glyphicon glyphicon-ok"></span></button><button  style="margin-left:10px;" class="btn btn-danger" onclick="refuserdemande();"><span class="glyphicon glyphicon-remove" ></span></button>';

$modif = 'Demande en attente';
$modifsupp = '<button class="btn btn-primary btn-danger" onclick="deleterequestcreate();"><span class="glyphicon glyphicon-remove"></span></button>';
$u = new Personnel();
$user = $u->getActiveUser($_SESSION['matricule']);
$result['data'] = array();
if ($user->getDroit() == "Utilisateur") {
    $demandes = $user->consulterDemandes($type);
    foreach ($demandes as $demande) {
       
    if ($type == "M") {
        
            if ($demande->getEtat() == "N") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    $modif);
            } elseif ($demande->getEtat() == "A" or $demande->getEtat() == "E") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'en cours de Modification');

            } elseif ($demande->getEtat() == "T") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Partage Modifié');

            }
            elseif ($demande->getEtat() == "R") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Modification Refusée');

            }


        }
        if ($type == "C") {
            if ($demande->getEtat() == "N") {

                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    'en attente',
                    'en attente',
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    $modifsupp);
            } elseif ($demande->getEtat() == "A" or $demande->getEtat() == "E") {

                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'en cours de création');

            } elseif ($demande->getEtat() == "T") {

                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Partage créé');

            }
            elseif ($demande->getEtat() == "R") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Modification Refusée');

            }

        
    }

    if ($type == "S") {
            if ($demande->getEtat() == "N") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'en attente');
            } elseif ($demande->getEtat() == "A" or $demande->getEtat() == "E") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'en cours de suppression');

            } elseif ($demande->getEtat() == "T") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Partage Supprimé');

            }
            elseif ($demande->getEtat() == "R") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Suppression Refusée');

            }

        }
    }


} elseif ($user->getDroit() == "Admin") {
    $demandes = $user->consulterAllDemandes($type);
    foreach ($demandes as $demande) {
    if ($type == "M") {
            if ($demande->getEtat() == "N") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    $approvemodif);
            } elseif ($demande->getEtat() == "A") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Modification Approuvée');

            } elseif ($demande->getEtat() == "T") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Demande Traitée');

            }elseif ($demande->getEtat() == "E") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Erreur de Modification');

            }elseif ($demande->getEtat() == "R") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Modification Refusée');

            }

        }
        if ($type == "C") {
            if ($demande->getEtat() == "N") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    'en attente',
                    'en attente',
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    $approve);
            } elseif ($demande->getEtat() == "A") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Création Approuvée');

            } elseif ($demande->getEtat() == "T") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Demande Traitée');

            }
            elseif ($demande->getEtat() == "E") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Erreur de Création');

            }
            elseif ($demande->getEtat() == "R") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Création Refusée');

            }
    }

    if ($type == "S") {
            if ($demande->getEtat() == "N") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    $approvesupp);
            } elseif ($demande->getEtat() == "A") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Suppression Approuvée');

            } elseif ($demande->getEtat() == "T") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Demande Traitée');

            }
            elseif ($demande->getEtat() == "E") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Erreur de Suppression');

            }
            elseif ($demande->getEtat() == "R") {
                $result['data'][] = array(
                    $demande->getId(),
                    $demande->getType(),
                    $demande->getDemandeur(),
                    $demande->getNomPartage(),
                    $demande->getNomServ(),
                    $demande->getNomDisque(),
                    $demande->getQuota(),
                    $collab,
                    $demande->getEtat(),
                    'Suppression Refusée');

            }

        }
    }

    }

 else {
    //technicien
}


echo json_encode($result);
?>