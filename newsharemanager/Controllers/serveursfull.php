<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();


$discs = '<button class="btn btn-primary" data-toggle="modal" data-target="#disquesmodal"><span class="glyphicon glyphicon-hdd"></span> Visualiser</button>';
$modifsupp = '<button class="btn btn-warning" data-toggle="modal" data-target="#editserver"><span class="glyphicon glyphicon-edit"></span> Modifier</button><button  style="margin-left:10px;" class="btn btn-danger" onclick="removeserver();"><span class="glyphicon glyphicon-remove" ></span>  Supprimer</button>';
$result['data'] = array();

$ser = new Serveur();
$serveurs = $ser->getAllServer();
foreach ($serveurs as $s) {
    $result['data'][] = array(
        $s->getId(),
        $s->getNomServ(),
        $discs,
        $s->getNomAdmin(),
        $s->getPwd(),
        $modifsupp);

}


echo json_encode($result);

?>