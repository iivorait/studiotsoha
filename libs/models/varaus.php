<?php

class Varaus {
    
    private $tunnus;
    private $tyontekija;
    private $asiakas;
    private $paivamaara;
    private $aloitusaika;
    private $kesto;
    private $palvelu;
    
    /*function __construct($tunnus, $tyontekija, $asiakas, $paivamaara, $aloitusaika, $kesto, $palvelu) {
        $this->tunnus = $tunnus;
        $this->tyontekija = $tyontekija;
        $this->asiakas = $asiakas;
        $this->paivamaara = $paivamaara;
        $this->aloitusaika = $aloitusaika;
        $this->kesto = $kesto;
        $this->palvelu = $palvelu;
    }*/

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
        return date("d.m.Y", strtotime($this->paivamaara));
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
    
    public function voikoPeruuttaa() {
        if($this->paivamaara > date("Y-m-d")) {
            return true;
        }
        return false;
    }
    
    public function getAjankohta() {
        $aloitusaika = date('G:i',strtotime($this->aloitusaika));
        $lopetusaika = date('G:i',strtotime($this->aloitusaika) + 60 * $this->kesto);
        return $aloitusaika . " - " . $lopetusaika;
    }

    public static function haeAsiakkaanVaraukset($asiakas) {
        $sql = "SELECT varaus.tunnus, paivamaara, aloitusaika, kesto, palvelu, tyontekija.nimi as kampaaja "
                . "FROM varaus, tyontekija "
                . "WHERE asiakas = ? AND tyontekija = tyontekija.tunnus "
                . "ORDER BY paivamaara DESC";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($asiakas->getTunnus()));
        
        /*if ($tulokset == null) {
            return null;
        } else {*/
            $varaukset = array();

            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $varaus = new Varaus();
                $varaus->setAloitusaika($tulos->aloitusaika);
                $varaus->setAsiakas($asiakas);
                $varaus->setKesto($tulos->kesto);
                $varaus->setPaivamaara($tulos->paivamaara);
                $varaus->setPalvelu($tulos->palvelu);
                $varaus->setTunnus($tulos->tunnus);
                $varaus->setTyontekija($tulos->kampaaja);
                
                $varaukset[] = $varaus;
            }
   
            return $varaukset;
        //}
    }
    
    public static function peruutaVaraus($id) {
        $sql = "DELETE FROM varaus WHERE tunnus = ?";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
    }
}
