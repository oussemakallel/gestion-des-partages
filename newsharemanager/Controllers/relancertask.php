<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_GET['id'])) {
    $u = new Personnel();
    $user = $u->getActiveUser($_SESSION['matricule']);
    $id = $_GET['id'];
    $user->relancer($id);
}

?>