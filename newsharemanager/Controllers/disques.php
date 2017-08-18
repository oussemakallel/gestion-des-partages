<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$res = '<option disabled selected value> -- selectionner un disque -- </option>';
if (isset($_GET['server'])) {
    $server = $_GET['server']; //nom serveur
    $serv = new Serveur();
    $list = $serv->getDisquesServername($server);
    foreach ($list as $d) {
        $res = $res . '<option val="' . $d->getNomDisque() . '">' . $d->getNomDisque() .
            '</option>';
    }


}
echo $res;


?>