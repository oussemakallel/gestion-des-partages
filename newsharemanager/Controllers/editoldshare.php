<?php

//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['oldserver']) and isset($_POST['olddisc']) and isset($_POST['pname']) and isset($_POST['quota'])) {
    $u = new Personnel();
    $user = $u->getActiveUser($_SESSION['matricule']);
    $pname = $_POST['pname'];
    $disc= $_POST['olddisc'];
    $server= $_POST['oldserver'];
    $quota = $_POST['quota'];
    if (isset($_POST['collabs']) and isset($_POST['permissions'])) {
        $collabs = $_POST['collabs'];
        $permissions = $_POST['permissions'];
        $user->editoldPartage($server,$disc,$_SESSION['matricule'],$pname,$quota,$users,$permissions);
    }else $user->editoldPartage($server,$disc,$_SESSION['matricule'],$pname,$quota);
}



?>