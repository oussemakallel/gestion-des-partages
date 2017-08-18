<?php
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
$result = '';
$editsuppadmin = '<td><a class="btn btn-danger remove_field_edit_share_admin"><span class="glyphicon glyphicon-remove"></span></a></td>';
$editsuppuser = '<td><a class="btn btn-danger remove_field_edit_share_user"><span class="glyphicon glyphicon-remove"></span></a></td>';
$u = new Personnel();
$user = $u->getActiveUser($_SESSION['matricule']);
if (strtoupper($user->getDroit()) == 'ADMIN')
    $edit = $editsuppadmin;
else
    $edit = $editsuppuser;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if(isset($_GET['isold'])){ 
        $edit='<td><a class="btn btn-danger remove_field_edit_old_share"><span class="glyphicon glyphicon-remove"></span></a></td>';
    }
    ob_start();
    $p = new Partage();
    $collabs = $p->listerCollaborateurs($id);
    ob_end_clean();

    foreach ($collabs as $collab) {
        $readcheck = '';
        $fullcheck = '';
        if (strtoupper($collab->getPermission()) == 'READ') {
            $readcheck = 'checked';
        } else
            $fullcheck = 'checked';
        $result = $result . '<tr><div class="form-group" ><td><input type="text" value="' .
            $collab->getPersonnel()->getMatricule() .
            '" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox" name="permissions[]" value="FULL" style="margin-right:6px;" ' .
            $fullcheck . '>FULL<input type="checkbox" name="permissions[]" value="READ" style="margin-left:10px;margin-right:6px;" ' .
            $readcheck . '>READ</td>' . $edit . '</div></tr>';
    }
}
echo $result;






?>