<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();

if (isset($_GET['server']))
    $server = $_GET['server'];
$result['data'] = array();
$serv = new Serveur();
$list = $serv->getDisquesServername($server);
foreach ($list as $d) {
    $result['data'][] = array(
        $d->getNomDisque(),
        $d->getEspaceLibreHard(),
        $d->getEspaceTotalHard(),
        $d->getEspaceReserve(),
        $d->getEspaceAllouable());
}


echo json_encode($result);

?>