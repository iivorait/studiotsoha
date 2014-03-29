<?php

class Palveluntarjoaja {
    
    private $palvelu;
    private $tyontekija;
    
    function __construct($palvelu, $tyontekija) {
        $this->palvelu = $palvelu;
        $this->tyontekija = $tyontekija;
    }

    public function getPalvelu() {
        return $this->palvelu;
    }

    public function getTyontekija() {
        return $this->tyontekija;
    }

    public function setPalvelu($palvelu) {
        $this->palvelu = $palvelu;
    }

    public function setTyontekija($tyontekija) {
        $this->tyontekija = $tyontekija;
    }


}

