<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['id'])) {
    $serv = new Serveur();
    $serv->deleteServ($_POST['id']);
}



?>