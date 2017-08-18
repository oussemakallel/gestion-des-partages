<?php

/*
executer la table tache
*/

set_time_limit(2400);

chdir(dirname( dirname(__FILE__) ));

require_once '/Models/Serveur.php' ;
require_once '/Models/Disque.php' ;
require_once '/Models/Personnel.php' ;
require_once '/Models/Administrateur.php' ;
require_once '/Models/Demande.php' ;
require_once '/Models/Partage.php' ;
require_once '/Models/Config.php';

chdir(dirname(__FILE__));
 
$modifiedservers=array();
$a=new Administrateur();
$tasks=$a->getundoneTasks();
$marks=$a->getundoneTasks();
foreach($marks as $mark) 
{
    $a->markTask($mark['id']);
}
foreach($tasks as $task) 
{
$partage=new Partage();
$demande = new Demande();
$demande=$demande->getDemande($task['id_demande']);
    $res= $demande->getListCollaborateur();
    unset($collab);
    unset($permission);
    $collab=array();
    $permission=array();
    foreach ($res as $r){
        $collab[]=escapeshellarg($r->getPersonnel());
        $permission[]=escapeshellarg($r->getPermission());
    }
$s=new Serveur();
$s=$s->getServerByname($demande->getNomServ());
$modifiedservers[$s->getNomServ()]=$s;
$server = $s ->getNomServ() ;
$user = $s ->getNomAdmin() ;
$pass = $s ->getPwd() ;
$fulldrive=$demande->getNomDisque();
$drive = substr_replace($demande->getNomDisque(), "", -1);
$quota = $demande->getQuota();
$shname = $demande->getNomPartage();
$assocpartage=new Partage();
$count=$assocpartage->searchIfShareExist($server, $demande->getNomPartage());    
if ($count) {
    $assocpartage=$assocpartage->getPartage($demande->getNomPartage(), $server); 
    $path=$assocpartage->getCheminLocal();
    echo $path;
} else $path="$fulldrive\\$shname";
echo $path;
$tailcmd='';
exec("cscript wmiconnectioncheck.vbs $server $user $pass",$output,$retval);
if ($retval != 0){
    $a->setExecTask('E',"PHP EXEC FAIL",$task['id']);
    $a->generateErrorNotif($task['id'],"PHP EXEC FAIL");
    $demande->closeerrDemand($task['id_demande']);continue;    
}
elseif ($output['3'] !='OK')
{
    $a->setExecTask('E',"Erreur de connection WMI",$task['id']);
    $a->generateErrorNotif($task['id'],"Erreur de connection WMI");
    $demande->closeerrDemand($task['id_demande']);continue;
    
}
if(strtoupper($task['type'])=='C'){
    $ip=gethostbyname($server);
    ob_start(); 
    $last_line = system("cmd /c checkhost.bat $ip ", $retval);
    ob_clean();

if ($last_line == 'FAIL') {
    $a->setExecTask('E',"$server est indisponible",$task['id']);
    $a->generateErrorNotif($task['id'],"$server est indisponible");
    $demande->closeerrDemand($task['id_demande']);continue;
}

unset($output);

exec("cscript checkShare.vbs $server $user $pass $shname ",$output);
if ($output['3'] == '1') {
    $a->setExecTask('E',"$shname est déja existant sur $server",$task['id']);
    $a->generateErrorNotif($task['id'],"$shname est déja existant sur $server");
   $demande->closeerrDemand($task['id_demande']);continue;
}

unset($output);
exec("cscript fspace.vbs $server $user $pass $drive ",$output);

if(floatval($output['3']) < $quota) {
    
     $a->setExecTask('E','Espace libre insuffissant',$task['id']);
     $a->generateErrorNotif($task['id'],'Espace libre insuffissant');
    $demande->closeerrDemand($task['id_demande']);continue;
}
ob_start(); 

 $last_line = system("cmd /c checkfolder.bat $server $user $pass $drive $shname ", $retval);

ob_clean();
    
if ($last_line == 'SUCCESS') {
    
     $a->setExecTask('E','Dossier deja existant',$task['id']);
     $a->generateErrorNotif($task['id'],'Dossier deja existant');
    $demande->closeerrDemand($task['id_demande']);continue;
    
}
    
ob_start(); 

 $last_line = system("cmd /c cfolder.bat $server $user $pass $drive $shname ", $retval);

ob_clean();

    
ob_start(); 

 $last_line = system("cmd /c checkfolder.bat $server $user $pass $drive $shname ", $retval);

ob_clean();


if ($last_line != 'SUCCESS') {
     $a->setExecTask('E','Erreur au cours de la création du dossier',$task['id']);
     $a->generateErrorNotif($task['id'],'Erreur au cours de la création du dossier');
    $demande->closeerrDemand($task['id_demande']);continue;
    
}

foreach ($collab as $key=>$line){
    $ruser = $line;
    $perm = $permission[$key];
    unset($output);
    $tailcmd = $tailcmd."/GRANT:$ruser,$perm ";   
}
substr_replace($tailcmd, "", -1);


$cmd = "\"cmd /c net share $shname=$path /unlimited ".$tailcmd."\"";
unset($output);

exec("cscript execute.vbs $server $user $pass $cmd",$output);

unset($output);

exec("cscript checkShare.vbs $server $user $pass $shname",$output);


if ($output['3'] == '0') {
     
    ob_start(); 
   
    $output = system("cmd /c rmfolder.bat $server $user $pass $drive $shname ", $retval);
   
    ob_clean();
    
        $a->setExecTask('E','Erreur de création du partage',$task['id']);
        $a->generateErrorNotif($task['id'],'Erreur de création du partage');
        $demande->closeerrDemand($task['id_demande']);continue;
}
else {
        $a->setExecTask('T',"Dossier partagé @ l'adresse \\\\$server\\$shname",$task['id']);
        $a->generateSuccessNotif($task['id'],"Dossier partagé @ l'adresse \\\\$server\\$shname");
        $demande->closeDemand($task['id_demande']);continue;
}

}
    elseif(strtoupper($task['type'])=='M'){
        echo 'Modification';
        $ip=gethostbyname($server);
        echo $ip;
    ob_start(); 
    $last_line = system("cmd /c checkhost.bat $ip ", $retval);
    ob_clean();
        echo "ping test: $last_line";

if ($last_line == 'FAIL') {
    $a->setExecTask('E',"$server est indisponible",$task['id']);
    $a->generateErrorNotif($task['id'],"$server est indisponible");
    $demande->closeerrDemand($task['id_demande']);continue;
}

unset($output);

exec("cscript checkShare.vbs $server $user $pass $shname",$output);


if ($output['3'] != '1') {
    $a->setExecTask('E',"$shname n'existe pas sur $server",$task['id']);
    $a->generateErrorNotif($task['id'],"$shname n'existe pas sur $server");
    $demande->closeerrDemand($task['id_demande']);continue;
}

unset($output);
exec("cscript fspace.vbs $server $user $pass $drive ",$output);

   
if(floatval($output['3']) < $quota) {
    
     $a->setExecTask('E','Espace libre insuffissant',$task['id']);
     $a->generateErrorNotif($task['id'],'Espace libre insuffissant');
     $demande->closeerrDemand($task['id_demande']);continue;
}
 
$cmd = "\"cmd /c net share $shname /d\"";
unset($output);
exec("cscript execute.vbs $server $user $pass $cmd",$output);
        print_r($output);
echo $cmd;        
foreach ($collab as $key=>$line){
    $ruser = $line;
    $perm = $permission[$key];
    $tailcmd = $tailcmd."/GRANT:$ruser,$perm ";   
    }
substr_replace($tailcmd, "", -1);
        
sleep(5);

$cmd = "\"cmd /c net share $shname=$path /unlimited ".$tailcmd."\"";
        echo $cmd;
unset($output);
exec("cscript execute.vbs $server $user $pass $cmd",$output);
        print_r($output);

unset($output);

exec("cscript checkShare.vbs $server $user $pass $shname",$output);


if ($output['3'] != '1') {   
        $a->setExecTask('E','Erreur de Modification du partage',$task['id']);
        $a->generateErrorNotif($task['id'],'Erreur de Modification du partage');
        $demande->closeerrDemand($task['id_demande']);continue;
}
else {
        $a->setExecTask('T',"partage Modifié @ l'adresse \\\\$server\\$shname",$task['id']);
        $a->generateSuccessNotif($task['id'],"partage Modifié @ l'adresse \\\\$server\\$shname");
        $demande->closeDemand($task['id_demande']);continue;
}
   
}
    else{
        
        $ip=gethostbyname($server);
    ob_start(); 
    $last_line = system("cmd /c checkhost.bat $ip ", $retval);
    ob_clean();

if ($last_line == 'FAIL') {
    $a->setExecTask('E',"$server est indisponible",$task['id']);
    $a->generateErrorNotif($task['id'],"$server est indisponible");
    $demande->closeerrDemand($task['id_demande']);continue;
}

unset($output);

exec("cscript checkShare.vbs $server $user $pass $shname ",$output);

if ($output['3'] == '0') {
    $a->setExecTask('E',"$shname n'existe pas sur $server",$task['id']);
    $a->generateErrorNotif($task['id'],"$shname n'existe pas sur $server");
    $demande->closeerrDemand($task['id_demande']);continue;
}

$cmd = "\"cmd /c net share $shname /d \"";

unset($output);
exec("cscript execute.vbs $server $user $pass $cmd",$output);

unset($output);
exec("cscript checkShare.vbs $server $user $pass $shname",$output);


if ($output['3'] == '1') {   
        $a->setExecTask('E','Erreur de Suppression du partage',$task['id']);
        $a->generateErrorNotif($task['id'],'Erreur de Suppression du partage');
        $demande->closeerrDemand($task['id_demande']);continue;
        
}
else {
        $a->setExecTask('T',"partage Supprimé du réseau",$task['id']);
        $a->generateSuccessNotif($task['id'],"partage Supprimé du réseau");
        $demande->closeDemand($task['id_demande']);continue;
}
   
        
}
     



}

$disque = new Disque();
$partage = new Partage();


foreach ($modifiedservers as $s) {
    unset($nS);
    unset($nA);
    unset($p);
    unset($list);
    $nS = $s->getNomServ();
    echo("Nom Serveur : " . $nS . "<br>");
    $nA = $s->getNomAdmin();
    echo("Administrateur : " . $nA. "<br>");
    $p = $s->getPwd();
    $ip = gethostbyname($nS);
    ob_start();
    $last_line = system("cmd /c checkhost.bat $ip ", $retval);
    ob_clean();
    if ($last_line != 'FAIL') {
        exec("cscript listerLesPartageServeur.vbs $nS $nA $p ", $list, $ERR);
                   $i = 3 ;
      while ( $i < sizeof($list)) {

         $partage=new Partage($list[$i],$list[$i+1],$list[$i+2],$list[$i+3]) ;
         $j=$i+4 ;
         $n = $j ;
         $listCollab = array() ;
         while ($list[$j]!="***") {     
           $collab=new Permission($list[$j],$list[$j+1]) ;
           $listCollab[] = $collab ;         
           $j=$j+2 ;
         }
         $partage->setListCollaborateursAvecLeurPermission($listCollab) ;
         $listPartages[] =$partage ;
          
        $i=1+$j ;
      }
      $partage->insertShare($listPartages) ;
      $partage->deleteCollab($listPartages) ; 
      $partage->deleteShareFromVBS($listPartages) ;
    }
}

?>