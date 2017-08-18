<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['server']) and isset($_POST['disc']) and isset($_POST['pname'])) {
    $u = new Personnel();
    $user = $u->getActiveUser($_SESSION['matricule']);
    $user->deleteoldPartage($_POST['server'],$_POST['disc'],$_SESSION['matricule'],$_POST['pname']);
}



?>