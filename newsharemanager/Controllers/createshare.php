<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
if (isset($_POST['quota']) and isset($_POST['pname']) and isset($_POST['server']) and
    isset($_POST['disc'])) {
    $u = new Personnel();
    $user = $u->getActiveUser($_SESSION['matricule']);
    $pname = $_POST['pname'];
    $quota = $_POST['quota'];
    $server = $_POST['server'];
    $disc = $_POST['disc'];
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
        $user->creerPartage($pname, $quota, $server, $disc, $collaborateur);

    } else {
        $user->creerPartage($pname, $quota, $server, $disc);

    }
}
?>