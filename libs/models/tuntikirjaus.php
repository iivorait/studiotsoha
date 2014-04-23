<?php

class Tuntikirjaus {
    
    private $tyontekija; //olio
    private $paivamaara;
    private $tuntimaara;
    private $kommentti;
    private $virheet = array();

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
        
        if (trim($paivamaara) == '') {
            $this->virheet['paivamaara'] = "Päivämäärä ei saa olla tyhjä.";
        } else {
            unset($this->virheet['paivamaara']);
        }
    }

    public function setTuntimaara($tuntimaara) {
        $this->tuntimaara = $tuntimaara;
        
        if (!is_numeric($tuntimaara)) {
            $this->virheet['tuntimaara'] = "Tuntimäärän täytyy olla numero.";
        } else if ($tuntimaara <= 0) {
            $this->virheet['tuntimaara'] = "Tuntimäärän täytyy olla positiivinen.";
        } else {
            unset($this->virheet['tuntimaara']);
        }
    }

    public function setKommentti($kommentti) {
        $this->kommentti = $kommentti;
    }

    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    public function ylikirjoitaKantaan() {
        $sql = "DELETE FROM tuntikirjaus WHERE tyontekija = ? AND paivamaara = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->tyontekija->getTunnus(), $this->paivamaara));
        
        $sql = "INSERT INTO tuntikirjaus (tyontekija, paivamaara, tuntimaara, kommentti) VALUES (?,?,?,?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->tyontekija->getTunnus(), $this->paivamaara, $this->tuntimaara, $this->kommentti));
        
        return $ok;
    }
    
    public function poistaKannasta() {
        $sql = "DELETE FROM tuntikirjaus WHERE tyontekija = ? AND paivamaara = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->tyontekija->getTunnus(), $this->paivamaara));
        
        return $ok;
    }
    
    public static function haeTuntikirjaus($tyontekija_id, $paivamaara) {
        $sql = "SELECT * FROM tuntikirjaus WHERE tyontekija = ? AND paivamaara = ?";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tyontekija_id, $paivamaara));
        
        $tulos = $kysely->fetchObject();

        if ($tulos == null) {
            return null;
        } else {
            $tuntikirjaus = new Tuntikirjaus();
            $tuntikirjaus->setKommentti($tulos->kommentti);
            $tuntikirjaus->setPaivamaara($tulos->paivamaara);
            $tuntikirjaus->setTuntimaara($tulos->tuntimaara);
            $tuntikirjaus->setTyontekija(Tyontekija::haeTyontekija($tulos->tyontekija));

            return $tuntikirjaus;
        }
    }
}

