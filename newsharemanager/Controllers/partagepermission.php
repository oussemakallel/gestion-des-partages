<?php

chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$result['data'] = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $collabs = array();
    ob_start();
    $p = new Partage();
    $collabs = $p->listerCollaborateurs($id);
    ob_end_clean();

    foreach ($collabs as $collab) {
        if(!empty($collab->getPersonnel())){
            $result['data'][] = array($collab->getPersonnel()->getMatricule(), $collab->getPermission());
        }
        
    }

}

echo json_encode($result);




?>