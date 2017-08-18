<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$res = 'null';
$u = new Personnel();
$user = $u->getActiveUser($_SESSION['matricule']);
$notif = new Notification();
$notifs = array();
if (isset($_POST['dropid'])) {
    $notif->setEtatNotifRead($_POST['dropid']);
    echo 'ok' . $_POST['dropid'];
} else {
    $allnotif = $notif->getNotifications($_SESSION['matricule']);
    foreach ($allnotif as $line) {
        $notifs[][] = array(
            $line->getId(),
            '',
            $line->getMessage(),
            $line->getType());
    }
    echo json_encode($notifs);
}
?>