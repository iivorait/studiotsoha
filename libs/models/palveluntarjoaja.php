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

    public static function tarjoaakoTyontekija($tyontekija, $palvelu) {
        $sql = "SELECT COUNT(1) AS tarjoaa FROM palveluntarjoaja WHERE tyontekija = ? AND palvelu = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tyontekija, $palvelu));

        $tulos = $kysely->fetchObject();

        if ($tulos->tarjoaa == 0) {
            return false;
        } else {   
            return true;
        }
    }
    
    public static function lisaaPalveluntarjoaja($palvelu, $tyontekija) {
        if(Palveluntarjoaja::tarjoaakoTyontekija($tyontekija, $palvelu)) {
            return false;
        }
        
        $sql = "INSERT INTO palveluntarjoaja (palvelu, tyontekija) VALUES (?,?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($palvelu, $tyontekija));
        
        return $ok;
    }
    
    public static function poistaPalveluntarjoaja($palvelu, $tyontekija) {
        $sql = "DELETE FROM palveluntarjoaja WHERE palvelu = ? AND tyontekija = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($palvelu, $tyontekija));
        
        return $ok;
    }
}

