<?php
set_time_limit(2400);
chdir(dirname( dirname(__FILE__) ));

require_once '/Models/Serveur.php' ;
require_once '/Models/Disque.php' ;
require_once '/Models/Personnel.php' ;
require_once '/Models/Administrateur.php' ;
require_once '/Models/Demande.php' ;
require_once '/Models/Config.php';

chdir(dirname(__FILE__));
$serveur=new Serveur() ;
$disque=new Disque() ;
$partage=new Partage() ;
$serveurs=$serveur->getAllServer() ;

foreach ($serveurs as $s) {

  unset($nS);
  unset($nA);
  unset($p);
  unset($list);
  $listPartages = array() ;
  $nS=$s->getNomServ() ;
  $nA=$s->getNomAdmin();
  $p=$s->getPwd();
$ip = gethostbyname($nS);
    ob_start();
    $last_line = system("cmd /c checkhost.bat $ip ", $retval);
    ob_clean();
    if ($last_line != 'FAIL') {
    exec("cscript wmiconnectioncheck.vbs $nS $nA $p",$output,$retval);
if ($retval != 0){
   continue;    
}
elseif ($output['3'] !='OK')
{
  continue;
    
}
    exec("cscript listerLesPartageServeur.vbs $nS $nA $p ", $list ,$ERR);
    echo count($list) ;
      if(sizeof($list)>3){
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

}




?>
