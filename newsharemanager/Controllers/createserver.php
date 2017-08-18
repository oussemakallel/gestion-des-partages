<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['sname']) and isset($_POST['login']) and isset($_POST['pass'])) {

    $server = $_POST['sname'];
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $serv = new Serveur();
    $serv->addServer($server, $login, $pass);


}



?>