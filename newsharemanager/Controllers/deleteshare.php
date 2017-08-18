<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['id'])) {
    $u = new Personnel();
    $user = $u->getActiveUser($_SESSION['matricule']);
    $user->SuppressionPartage($_POST['id']);
}


?>