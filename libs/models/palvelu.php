<?php

class Palvelu {
    
    private $tunnus;
    private $nimi;
    private $hinta;
    private $kesto;
    private $kuvaus;
    
    function __construct($tunnus, $nimi, $hinta, $kesto, $kuvaus) {
        $this->tunnus = $tunnus;
        $this->nimi = $nimi;
        $this->hinta = $hinta;
        $this->kesto = $kesto;
        $this->kuvaus = $kuvaus;
    }

    public function getTunnus() {
        return $this->tunnus;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getHinta() {
        return $this->hinta;
    }

    public function getKesto() {
        return $this->kesto;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setHinta($hinta) {
        $this->hinta = $hinta;
    }

    public function setKesto($kesto) {
        $this->kesto = $kesto;
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
    }


}