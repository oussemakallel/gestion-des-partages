<?php 
spl_autoload_register(function ($class) {
    include  $class . '.php';
});
Class Permission
{
private $nomPartage ;
private $nomServ ;
private $personnel ;
private $permission ;



public function __construct()
{
	$ctp = func_num_args();
    $args = func_get_args();
            switch($ctp)
            {
                case 0:
                break;
                case 2:
                 $this->personnel = $args[0];
                 $this->permission = $args[1];
                break ;    
                case 4:
                $this->nomPartage  = $args[0];
                $this->nomServ     = $args[1];
                $this->personnel   = $args[2];
                $this->permission  = $args[3];
                break;
                default:
                break;
            }
}



public function getPersonnel()
{
    return $this->personnel;
}
 
public function setPersonnel($personnel)
{
    $this->personnel = $personnel;
    return $this;
}

public function getPermission()
{
    return $this->permission;
}
 
public function setPermission($permission)
{
    $this->permission = $permission;
    return $this;
}

public function getNomServ()
{
    return $this->nomServ;
}
 
public function setNomServ($nomServ)
{
    $this->nomServ = $nomServ;
    return $this;
}

public function getNomPartage()
{
    return $this->nomPartage;
}
 
public function setNomPartage($nomPartage)
{
    $this->nomPartage = $nomPartage;
    return $this;
}

}



?>