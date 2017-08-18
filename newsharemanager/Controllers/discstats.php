<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$result = '';
if (isset($_GET['drive']) and isset($_GET['server'])) {
    $drive = $_GET['drive'];
    $server = $_GET['server'];


    /*requete*/
    $serv = new Serveur();
    $disc = new Disque();
    $disc->getDisque($serv->getIdServerByname($server), $drive);
    $sizeActual = $disc->calculateSizeOfActualShares($server, $drive);
    $espaceReserve = $disc->calculateReservedSpace($server, $drive);
    $SizeOfActualSharesNoDemanded = $disc->calculateSizeOfActualSharesNoDemanded($server,
        $drive);

    $disc->insertOrUpdateDisqueInfo($server, $drive, $disc->getEspaceLibreHard(), $disc->
        getEspaceTotalHard(), $espaceReserve, $disc->getEspaceLibreHard() - $espaceReserve +
        ($sizeActual - $SizeOfActualSharesNoDemanded));
    $disc=$disc->getDisque($serv->getIdServerByname($server), $drive);
    $espaceallouable = $disc->getEspaceAllouable();
    $espacereserve = $disc->getEspaceReserve();


    $result = '
    <div class="table-responsive">
						<table class="text-center table table-striped table-bordered m-b-none">
							<thead>
								<tr>
			
						<th class="text-center">
							Espace Allouable
						</th>
						<th class="text-center">
				            Espace Réservé
						</th>
                        </tr>
							</thead>
							<tbody>
                            <tr>
                            <td>
                            ' . $espaceallouable . '
                            
                            </td>
                            <td>
                            ' . $espacereserve . '
                            </td>
                            </tr>
							</tbody>
						</table>
					</div>
    ';

}
echo $result;


?>