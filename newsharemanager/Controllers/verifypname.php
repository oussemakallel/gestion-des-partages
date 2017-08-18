<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$result = '';

if (isset($_GET['server']) and isset($_GET['pname'])) {
    $server = $_GET['server'];
    $pname = $_GET['pname'];
    ob_start();
    $p = new Partage();
    $c = $p->searchIfShareExist($server, $pname);
    ob_end_clean();
    if ($c != 0)
        $result = '<span class="glyphicon glyphicon-remove" style="color:red;">';
    else
        $result = '<span class="glyphicon glyphicon-ok" style="color:green;"></span>';
}
echo $result;

?>