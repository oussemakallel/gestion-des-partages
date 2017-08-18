<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$result = '<option disabled selected value> -- selectionner un serveur --</option>';
$ser = new Serveur();
$serveurs = $ser->getAllServer();
foreach ($serveurs as $s) {
    $result = $result . '<option val="' . $s->getNomServ() . '">' . $s->getNomServ() .
        '</option>';
}
echo $result;




?>