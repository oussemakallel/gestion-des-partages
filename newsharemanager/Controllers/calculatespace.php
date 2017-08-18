<?php 

chdir(dirname( dirname(__FILE__) ));

require '/Models/Serveur.php' ;
require '/Models/Disque.php' ;
require '/Models/Personnel.php' ;
require '/Models/Administrateur.php' ;
require '/Models/Demande.php' ;
require '/Models/Config.php';

chdir(dirname(__FILE__));
$serveur = new Serveur();
$disque = new Disque();

$serveurs = $serveur->getAllServer();
$res="";
foreach ($serveurs as $s) {
    $res = $res."serveur : $drive".'<br/>';
    $server = $nS = $s->getNomServ();
    $discs=$serveur->getDisquesServername($server);
    foreach($discs as $disc){
    $drive=$disc->getNomDisque();  
    $sizeActual = $disc->calculateSizeOfActualShares($server, $drive);
    $espaceReserve = $disc->calculateReservedSpace($server, $drive);
    $SizeOfActualSharesNoDemanded = $disc->calculateSizeOfActualSharesNoDemanded($server,
        $drive);

    $disc->insertOrUpdateDisqueInfo($server, $drive, $disc->getEspaceLibreHard(), $disc->
        getEspaceTotalHard(), $espaceReserve, $disc->getEspaceLibreHard() - $espaceReserve +
        ($sizeActual - $SizeOfActualSharesNoDemanded));
    
    $espaceallouable = $disc->getEspaceAllouable();
    $espacereserve = $disc->getEspaceReserve();

    $res = $res."disque : $drive".'<br/>';
    $res = $res."sizeActual : $sizeActual".'<br/>';
    $res = $res."espaceReserve : $espaceReserve".'<br/>';
    $res = $res."SizeOfActualSharesNoDemanded : $SizeOfActualSharesNoDemanded".'<br/>';
    $res = $res."espaceAllouable : $espaceallouable".'<br/>';
    $res = $res."espace Reserve : $espacereserve".'<br/>';
    }
}
echo $res;
?>