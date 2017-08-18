<?php
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$remclass = '';
if (isset($_GET['id']) and isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    if (strtoupper($type) == 'C')
        $remclass = 'remove_field_approve_create';
    else
        $remclass = 'remove_field_modif';
}
$result = '';

$demande = new Demande();
$collabs = $demande->getCollaborateur($id);

foreach ($collabs as $collab) {
    $readcheck = '';
    $fullcheck = '';
    if (strtoupper($collab->getPermission()) == 'READ') {
        $readcheck = 'checked';
    } else
        $fullcheck = 'checked';
    $result = $result . '<tr><div class="form-group" ><td><input type="text" value="' .
        $collab->getPersonnel() .
        '" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox" name="permissions[]" value="FULL" style="margin-right:6px;" ' .
        $fullcheck . '>FULL<input type="checkbox" name="permissions[]" value="READ" style="margin-left:10px;margin-right:6px;" ' .
        $readcheck . '>READ</td><td><a class="btn btn-danger ' . $remclass .
        '"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>';
}


echo $result;



?>