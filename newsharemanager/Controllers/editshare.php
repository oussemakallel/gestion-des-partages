<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['id']) and isset($_POST['pname']) and isset($_POST['quota'])) {
    $u = new Personnel();
    $user = $u->getActiveUser($_SESSION['matricule']);
    $id = $_POST['id'];
    $pname = $_POST['pname'];
    $quota = $_POST['quota'];
    if (isset($_POST['collabs']) and isset($_POST['permissions'])) {
        $collabs = $_POST['collabs'];
        $permissions = $_POST['permissions'];
        $user->editPartage($id, $pname, $quota, $collabs, $permissions);
        exit();
    }

    $user->editPartage($id, $pname, $quota);
}



?>