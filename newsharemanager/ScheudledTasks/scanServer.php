<?php
set_time_limit(2400);
/**
 * scanner des serveur et disque
 */
chdir(dirname( dirname(__FILE__) ));

require_once '/Models/Serveur.php' ;
require_once '/Models/Disque.php' ;
require_once '/Models/Personnel.php' ;
require_once '/Models/Administrateur.php' ;
require_once '/Models/Demande.php' ;
require_once '/Models/Config.php';

chdir(dirname(__FILE__));
$serveur = new Serveur();
$disque = new Disque();
$cfg = new Config();


$serveurs = $serveur->getAllServer();

foreach ($serveurs as $s) {
    unset($nS);
    unset($nA);
    unset($p);
    unset($list);
    $nS = $s->getNomServ();
    $nA = $s->getNomAdmin();
    $p = $s->getPwd();
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
        exec("cscript scanServer.vbs $nS $nA $p ", $list, $ERR);
        $cfg->errlogtxt("cscript scanServer.vbs $nS $nA $p ");
        $disque->deleteDisqueInfo($list);
        if (sizeof($list) > 3) {
            $cfg->errlogtxt(print_r($list,TRUE));
            $disque->scanDisquesVBS($list);
        }
    }
}

?>