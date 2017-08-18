<?php
chdir('../.') ;
require getcwd().'/Models/Autoloader.php' ;
Autoloader::register() ;
session_start();
$u=new Personnel();
$user=$u->getActiveUser($_SESSION['matricule']);
if (isset($_GET['id_demande'])) {
   $user->demandeDeSupprission($_GET['id_demande']) ;
}

?>