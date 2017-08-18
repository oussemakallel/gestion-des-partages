<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['id']) and isset($_POST['sname']) and isset($_POST['login']) and
    isset($_POST['pass'])) {
    $serv = new Serveur();
    $serv->editServer($_POST['id'], $_POST['sname'], $_POST['login'], $_POST['pass']);
}



?>