<?php

spl_autoload_register(function ($class) {
    include $class . '.php';
});

Class Utilisateur extends Personnel {

    private $partagesPermiss = array();
    private $partages = array();

    public function __construct($matricule, $nom, $prenom) {
        parent::__construct($matricule, $nom, $prenom, "Utilisateur");
    }

    public function getPartages() {
        return $this->partages;
    }

    public function setPartages($partages) {
        $this->partages = $partages;
        return $this;
    }

    public function getPartagesPermiss() {
        return $this->partagesPermiss;
    }

    public function setPartagesPermiss($partagesPermiss) {
        $this->partagesPermiss = $partagesPermiss;
        return $this;
    }

}

?>