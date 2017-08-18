<?php
spl_autoload_register(function ($class) {
    include  $class . '.php';
});

Class Technicien extends Personnel
{

public function __construct($matricule, $nom, $prenom)
    {
        parent::__construct($matricule, $nom, $prenom,"Technicien");
        
    }
} 

?>