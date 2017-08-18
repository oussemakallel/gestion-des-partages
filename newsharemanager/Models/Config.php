<?php

class Config {

    //date_default_timezone_set('UTC');

    private $urlBase = "/GP/";
    private $applicationName = "gestion partage";
    private $applicationLogRep = "C:\\WebLog\\";
    private $dataBase = "gestionpartage";
    private $dataBaseHostname = "localhost";
    private $dataBaseUsername = "root";
    private $dataBasePassword = "";
    // Active Directory
    private $ldapHost = "172.28.14.1";
    private $ldapName = "biat";
    private $ldapPort = 389;
    private $ldapRdn = 'risuser';
    private $ldapPass = 'ppp123P';
    private $ldapBaseDN = 'OU=Utilisateurs BIAT,DC=biat,DC=int';

    public function getUrlBase() {
        return $this->urlBase;
    }

    public function setUrlBase($urlBase) {
        $this->urlBase = $urlBase;
        return $this;
    }

    public function getApplicationName() {
        return $this->applicationName;
    }

    public function setApplicationName($applicationName) {
        $this->applicationName = $applicationName;
        return $this;
    }

    public function getApplicationLogRep() {
        return $this->applicationLogRep;
    }

    public function setApplicationLogRep($applicationLogRep) {
        $this->applicationLogRep = $applicationLogRep;
        return $this;
    }

    public function getDataBase() {
        return $this->dataBase;
    }

    public function setDataBase($dataBase) {
        $this->dataBase = $dataBase;
        return $this;
    }

    public function getDataBaseHostname() {
        return $this->dataBaseHostname;
    }

    public function setDataBaseHostname($dataBaseHostname) {
        $this->dataBaseHostname = $dataBaseHostname;
        return $this;
    }

    public function getDataBaseUsername() {
        return $this->dataBaseUsername;
    }

    public function setDataBaseUsername($dataBaseUsername) {
        $this->dataBaseUsername = $dataBaseUsername;
        return $this;
    }

    public function getDataBasePassword() {
        return $this->dataBasePassword;
    }

    public function setDataBasePassword($dataBasePassword) {
        $this->dataBasePassword = $dataBasePassword;
        return $this;
    }

    public function getLdapHost() {
        return $this->ldapHost;
    }

    public function setLdapHost($ldapHost) {
        $this->ldapHost = $ldapHost;
        return $this;
    }

    public function getLdapName() {
        return $this->ldapName;
    }

    public function setLdapName($ldapName) {
        $this->ldapName = $ldapName;
        return $this;
    }

    public function getLdapPort() {
        return $this->ldapPort;
    }

    public function setLdapPort($ldapPort) {
        $this->ldapPort = $ldapPort;
        return $this;
    }

    public function getLdapRdn() {
        return $this->ldapRdn;
    }

    public function setLdapRdn($ldapRdn) {
        $this->ldapRdn = $ldapRdn;
        return $this;
    }

    public function getLdapPass() {
        return $this->ldapPass;
    }

    public function setLdapPass($ldapPass) {
        $this->ldapPass = $ldapPass;
        return $this;
    }

    public function getLdapBaseDN() {
        return $this->ldapBaseDN;
    }

    public function setLdapBaseDN($ldapBaseDN) {
        $this->ldapBaseDN = $ldapBaseDN;
        return $this;
    }
    
    public function errlogtxt($errtxt) {
        $Login = NULL;
        if (isset($_SERVER['REMOTE_USER'])) {
            $Login = $_SERVER['REMOTE_USER'];
        }
        $datesystem = date("Ymd", time());
        $fp = fopen("D:\\WebLog\\" . "ShareManager" . '_errlog' . $datesystem . '.txt', 'a+');

        fwrite($fp, $Login . "\t" . date(DATE_RFC822) . "\t" . $errtxt . "\r\n");
        fclose($fp); //basta
    }

}

?>
