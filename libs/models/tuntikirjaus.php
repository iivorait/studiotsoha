<?php

class Tuntikirjaus {
    
    private $tyontekija;
    private $paivamaara;
    private $tuntimaara;
    private $kommentti;
    
    function __construct($tyontekija, $paivamaara, $tuntimaara, $kommentti) {
        $this->tyontekija = $tyontekija;
        $this->paivamaara = $paivamaara;
        $this->tuntimaara = $tuntimaara;
        $this->kommentti = $kommentti;
    }

    public function getTyontekija() {
        return $this->tyontekija;
    }

    public function getPaivamaara() {
        return $this->paivamaara;
    }

    public function getTuntimaara() {
        return $this->tuntimaara;
    }

    public function getKommentti() {
        return $this->kommentti;
    }

    public function setTyontekija($tyontekija) {
        $this->tyontekija = $tyontekija;
    }

    public function setPaivamaara($paivamaara) {
        $this->paivamaara = $paivamaara;
    }

    public function setTuntimaara($tuntimaara) {
        $this->tuntimaara = $tuntimaara;
    }

    public function setKommentti($kommentti) {
        $this->kommentti = $kommentti;
    }


}

