<?p
//done
chdir('../.');
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
  $p=new Personnel();
  $user=$p->getActiveUser($SESSION['matricule']); 
if(isset($_POST['id']) and isset($_POST['pname']) and $_POST['quota']){
    
    if(isset($_POST['collabs']) and isset ($_POST['permissions']))
    $user->approuverDemandeEdited($_POST['id'],$_POST['pname'],$_POST['quota'],$_POST['collabs'],$_POST['permissions']);
    else $user->approuverDemandeEdited($_POST['id'],$_POST['pname'],$_POST['quota']) ;
}








?>