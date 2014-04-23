<?php

class Varaus {
    
    private $tunnus;
    private $tyontekija;
    private $asiakas;
    private $paivamaara;
    private $aloitusaika;
    private $kesto;
    private $palvelutunnus;
    private $palvelu;
    private $toivomukset;
    private $virheet = array();

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
    
    public function getPalvelutunnus() {
        return $this->palvelutunnus;
    }

    public function getPalvelu() {
        return $this->palvelu;
    }
    
    public function getToivomukset() {
        return $this->toivomukset;
    }

    public function getVirheet() {
        return $this->virheet;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setTyontekija($tyontekija) {
        $this->tyontekija = Tyontekija::haeTyontekija($tyontekija);
        
        if ($this->tyontekija == null) {
            $this->virheet['tyontekija'] = "Valittua kampaajaa ei löytynyt";
        } else {
            unset($this->virheet['tyontekija']);
        }
    }

    public function setAsiakas($asiakas) {
        $this->asiakas = $asiakas;
    }

    public function setPaivamaara($paivamaara) {
        $this->paivamaara = $paivamaara;
        
        if (trim($paivamaara) == '') {
            $this->virheet['paivamaara'] = "Päivämäärä ei voi olla tyhjä";
        } else {
            unset($this->virheet['paivamaara']);
        }
    }

    public function setAloitusaika($aloitusaika) {
        $this->aloitusaika = $aloitusaika;
        
        if (trim($aloitusaika) == '') {
            $this->virheet['aloitusaika'] = "Aloitusaika ei voi olla tyhjä";
        } else {
            unset($this->virheet['aloitusaika']);
        }
    }

    public function setKesto($kesto) {
        $this->kesto = $kesto;
    }
    
    public function setPalvelutunnus($palvelutunnus) {
        $this->palvelutunnus = $palvelutunnus;
    }

    public function setPalvelu($palvelu) {
        $this->palvelu = $palvelu;
        
        if (trim($palvelu) == '') {
            $this->virheet['palvelu'] = "Et valinnut palvelua";
        } else {
            unset($this->virheet['palvelu']);
        }
    }
    
    public function setToivomukset($toivomukset) {
        $this->toivomukset = $toivomukset;
    }
    
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    public function voikoPeruuttaa() {
        if($this->paivamaara >= date("Y-m-d")) {
            return true;
        }
        return false;
    }
    
    public function voikoTyontekijaPeruuttaa() {
        if($this->paivamaara >= date("Y-m-d", time() - 60*60*24*7)) {
            return true;
        }
        return false;
    }
    
    public function getAjankohta() {
        $aloitusaika = date('G:i',strtotime($this->aloitusaika));
        $lopetusaika = date('G:i',strtotime($this->aloitusaika) + 60 * $this->kesto);
        return $aloitusaika . " - " . $lopetusaika;
    }
    
    public function lisaaKantaan() {
        $sql = "INSERT INTO varaus "
                . "(tyontekija, asiakas, paivamaara, aloitusaika, kesto, palvelu, toivomukset) "
                . "VALUES (?,?,?,?,?,?,?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        
        $ok = $kysely->execute(array($this->tyontekija->getTunnus(), $this->asiakas, $this->paivamaara,
            date('H:i:s', strtotime($this->aloitusaika)), $this->kesto, $this->palvelu, $this->toivomukset));
        
        return $ok;
    }
    
    public static function haeVaraus($tunnus) {
        $sql = "SELECT varaus.tunnus, asiakas, paivamaara, aloitusaika, kesto, palvelu, toivomukset, tyontekija.tunnus as kampaaja "
                . "FROM varaus, tyontekija "
                . "WHERE varaus.tunnus = ? AND tyontekija = tyontekija.tunnus ";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tunnus));

        $tulos = $kysely->fetchObject();
        
        if ($tulos == null) {
            return null;
        } else {
            $varaus = new Varaus();
            $varaus->setAloitusaika($tulos->aloitusaika);
            $varaus->setAsiakas(Asiakas::haeAsiakas($tulos->asiakas));
            $varaus->setKesto($tulos->kesto);
            $varaus->setPaivamaara($tulos->paivamaara);
            $varaus->setPalvelu($tulos->palvelu);
            $varaus->setTunnus($tulos->tunnus);
            $varaus->setTyontekija($tulos->kampaaja);
            $varaus->setToivomukset($tulos->toivomukset);
   
            return $varaus;
        }
        
    }

    public static function haeAsiakkaanVaraukset($asiakas) {
        $sql = "SELECT tunnus FROM varaus WHERE asiakas = ? ORDER BY paivamaara DESC";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($asiakas->getTunnus()));
        
        /*if ($tulokset == null) {
            return null;
        } else {*/
            $varaukset = array();

            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $varaus = Varaus::haeVaraus($tulos->tunnus);
                
                $varaukset[] = $varaus;
            }
   
            return $varaukset;
        //}
    }
    
    public static function haeTyontekijanVaraukset($tyontekija) {
        $sql = "SELECT tunnus FROM varaus WHERE tyontekija = ? ORDER BY paivamaara DESC, aloitusaika DESC";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tyontekija->getTunnus()));

        $varaukset = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $varaus = Varaus::haeVaraus($tulos->tunnus);

            $varaukset[] = $varaus;
        }

        return $varaukset;

    }
    
    public static function peruutaVaraus($id) {
        $sql = "DELETE FROM varaus WHERE tunnus = ?";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }
}
