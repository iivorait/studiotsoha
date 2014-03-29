<?php

class Varaus {
    
    private $tunnus;
    private $tyontekija;
    private $asiakas;
    private $paivamaara;
    private $aloitusaika;
    private $kesto;
    private $palvelu;
    
    function __construct($tunnus, $tyontekija, $asiakas, $paivamaara, $aloitusaika, $kesto, $palvelu) {
        $this->tunnus = $tunnus;
        $this->tyontekija = $tyontekija;
        $this->asiakas = $asiakas;
        $this->paivamaara = $paivamaara;
        $this->aloitusaika = $aloitusaika;
        $this->kesto = $kesto;
        $this->palvelu = $palvelu;
    }

    public function getTunnus() {
        return $this->tunnus;
    }

    public function getTyontekija() {
        return $this->tyontekija;
    }

    public function getAsiakas() {
        return $this->asiakas;
    }

    public function getPaivamaara() {
        return $this->paivamaara;
    }

    public function getAloitusaika() {
        return $this->aloitusaika;
    }

    public function getKesto() {
        return $this->kesto;
    }

    public function getPalvelu() {
        return $this->palvelu;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setTyontekija($tyontekija) {
        $this->tyontekija = $tyontekija;
    }

    public function setAsiakas($asiakas) {
        $this->asiakas = $asiakas;
    }

    public function setPaivamaara($paivamaara) {
        $this->paivamaara = $paivamaara;
    }

    public function setAloitusaika($aloitusaika) {
        $this->aloitusaika = $aloitusaika;
    }

    public function setKesto($kesto) {
        $this->kesto = $kesto;
    }

    public function setPalvelu($palvelu) {
        $this->palvelu = $palvelu;
    }


}