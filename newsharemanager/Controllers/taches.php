<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$reload = '<button class="btn btn-primary" onclick="relancertask();"><span class="glyphicon glyphicon-refresh"></span> Relancer</button>';
$result['data'] = array();

$u = new Personnel();
$user = $u->getActiveUser($_SESSION['matricule']);

$tasks = $user->getAllTasks();
foreach ($tasks as $task) {
    if (strtoupper($task['etat']) == "E")
        $result['data'][] = array(
            $task['id'],
            $task['id_demande'],
            $task['type'],
            $task['etat'],
            $task['res_exec'],
            $task['date_creation'],
            $reload);
    elseif (strtoupper($task['etat']) == "A")
        $result['data'][] = array(
            $task['id'],
            $task['id_demande'],
            $task['type'],
            $task['etat'],
            $task['res_exec'],
            $task['date_creation'],
            "en attente d'éxecution");
    elseif (strtoupper($task['etat']) == "T")
        $result['data'][] = array(
            $task['id'],
            $task['id_demande'],
            $task['type'],
            $task['etat'],
            $task['res_exec'],
            $task['date_creation'],
            "Tache Réussie");
}
echo json_encode($result);


?>