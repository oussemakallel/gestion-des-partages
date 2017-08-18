<?php
chdir('../.') ;
require getcwd().'/Models/Autoloader.php' ;
Autoloader::register() ;
session_start();
$u=new Personnel();
$user=$u->getActiveUser($_SESSION['matricule']);
if(isset($_GET['id_demande'] ) and isset($_GET['pname']) and isset($_GET['quota']) )
{
     if (isset($_GET['users'] )and isset($_GET['permissions'])  ) {
     	$user->editUserDemande($_GET['id_demande'],$_GET['pname'],$_GET['quota'] ,$_GET['users']  ,$_GET['permissions'] ) ;
     }
     else
     {
    $user->editUserDemande($_GET['id_demande'],$_GET['pname'],$_GET['quota'] ) ;
     }

       



}



?>