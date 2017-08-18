<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$u = new Personnel();
//remote-user
$user = $u->getActiveUser($_SESSION['matricule']);
if (isset($_POST['pname']) and isset($_POST['quota'])) {
    $quota = $_POST['quota'];
    $pname = $_POST['pname'];
    if (isset($_POST['collabs']) and isset($_POST['permissions'])) {

        $collabs = $_POST['collabs'];
        $permissions = $_POST['permissions'];
        $collaborateur = array();
        $i = 0;
        foreach ($permissions as $permission) {
            $p = new Permission($collabs[$i], $permission);
            $collaborateur[$i] = $p;
            $i = $i + 1;
        }
        $user->demandePartage($pname, $quota, $collaborateur);
    } else {
        $user->demandePartage($pname, $quota);
    }
}




?>