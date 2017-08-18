<?php
spl_autoload_register(function ($class) {
    include  $class . '.php';
}); 
class Notification extends Modele
{

 private $id ;
 private $message ;
 private $destinataire ;
 private $type ;
 private $etat ;


 public function __construct()
    {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 0:
                break;
                default:
                break;
            }
    }

public function getId()
{
    return $this->id;
}
 
public function setId($id)
{
    $this->id = $id;
    return $this;
}

public function getMessage()
{
    return $this->message;
}
 
public function setMessage($message)
{
    $this->message = $message;
    return $this;
}

public function getDestinataire()
{
    return $this->destinataire;
}
 
public function setDestinataire($destinataire)
{
    $this->destinataire = $destinataire;
    return $this;
}

public function getType()
{
    return $this->type;
}
 
public function setType($type)
{
    $this->type = $type;
    return $this;
}

public function getEtat()
{
    return $this->etat;
}
 
public function setEtat($etat)
{
    $this->etat = $etat;
    return $this;
}

public function getNotif($id)
{
    $sql="select * from notification where id = ?" ;
    $notifs=$this->executerRequete($sql,array($id)) ;
    foreach ($notifs as $notif) 
    {
       $this->id           = $notif['id'] ;
       $this->message      = $notif['message'] ;
       $this->destinataire = $notif['destinataire'] ;
       $this->type         = $notif['type'] ;
       $this->etat         = $notif['etat'] ;
    }
    return $this ;
}

public function getNotifications($matricule)
{
  $sql = 'select * from notification where destinataire = ? and etat = ?';
  $etat="unread" ;
  $notifs=$this->executerRequete($sql,array($matricule,$etat)) ;
  $notifications=array() ;
  $i=0;
  foreach ($notifs as $notif) 
  {
  	$notification=new Notification() ;
  	$notifications[$i]=$notification->getNotif($notif['id']) ;
  	$i=$i+1 ;
  }
  return $notifications ;


}

public function setEtatNotifRead($id)
{
  $sqlUpdate='update notification set etat =? where id = ?' ;
  $etat="read" ;
  $this->executerRequete($sqlUpdate,array($etat,$id)) ;
}




}

?>