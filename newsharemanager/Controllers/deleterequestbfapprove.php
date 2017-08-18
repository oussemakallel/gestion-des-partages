<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$u = new Personnel();
$user = $u->getActiveUser($_SESSION['matricule']);
if (isset($_POST['id'])) {
    $user->deleteUserDemandeNaprroved($_POST['id']);
}




?>