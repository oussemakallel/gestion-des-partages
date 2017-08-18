<?php

chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$res = 'null';
$u = new Personnel();
$user = $u->getActiveUser($_SESSION['matricule']);
if (isset($_POST['id']) and isset($_POST['pname']) and isset($_POST['quota']) and
    isset($_POST['server']) and isset($_POST['disc'])) {

    $user->approuverDemandes($_POST['id'], $_POST['pname'], $_POST['quota'], $_POST['collabs'],
        $_POST['permissions'], $_POST['server'], $_POST['disc']);
    $res = 'ok';
}

echo $res;









?>