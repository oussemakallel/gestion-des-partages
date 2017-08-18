<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();

if (isset($_GET['id']))
    $id = $_GET['id'];
$demande = new Demande();
$collabs = $demande->getCollaborateur($id);
$result['data'] = array();
foreach ($collabs as $collab) {
    $result['data'][] = array($collab->getPersonnel(), $collab->getPermission());
}


echo json_encode($result);




?>