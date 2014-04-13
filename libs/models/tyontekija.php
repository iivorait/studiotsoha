<?php

class Tyontekija {
    
    private $tunnus;
    private $sahkoposti;
    private $nimi;
    private $johtaja;
    private $kuvaus;
    private $salasana;
    private $kalenteri;
    
    public function getTunnus() {
        return $this->tunnus;
    }

    public function getSahkoposti() {
        return $this->sahkoposti;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getJohtaja() {
        return $this->johtaja;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }

    public function getSalasana() {
        return $this->salasana;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setSahkoposti($sahkoposti) {
        $this->sahkoposti = $sahkoposti;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setJohtaja($johtaja) {
        $this->johtaja = $johtaja;
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
    }

    public function setSalasana($salasana) {
        $this->salasana = $salasana;
    }
    
    public function getKalenteri() {
        return $this->kalenteri;
    }

    public function lataaKalenteri($paivamaara) {
        $sql = "SELECT aloitusaika, kesto FROM varaus WHERE tyontekija = $this->tunnus AND paivamaara = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($paivamaara));
        
        $kalenteri = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $aika = explode(":",$tulos->aloitusaika); //aika[0] = tunnit, aika[1] = minuutit
            $aikaajaljella = $tulos->kesto;
            
            while($aikaajaljella > 0) {
                $kalenteri[(int)$aika[0]][(int)$aika[1]] = true;
                $aika[1] += 15;
                if($aika[1] == 60) {
                    $aika[0]++;
                    $aika[1] = 0;
                }
                $aikaajaljella -= 15;
            }        
        }
        
        $this->kalenteri = $kalenteri;
    }
    
     public function haeTarjotutPalvelut() {
        $sql = "SELECT palvelu FROM palveluntarjoaja WHERE tyontekija = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->tunnus));
        
        $palvelut = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $palvelut[] = Palvelu::haePalvelu($tulos->palvelu);
        }

        return $palvelut;
    }

    /* Etsitään kannasta käyttäjätunnuksella ja salasanalla käyttäjäriviä */

    public static function etsiKayttajaTunnuksilla($sahkoposti, $salasana) {
        $sql = "SELECT tunnus FROM tyontekija WHERE sahkoposti = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti, md5($salasana . salasanaSuola)));

        $tulos = $kysely->fetchObject();
        
        if ($tulos == null) {
            return null;
        } else {   
            return Tyontekija::haeTyontekija($tulos->tunnus);
        }
    }

    public static function haeTyontekija($id) {
        $sql = "SELECT * FROM tyontekija WHERE tunnus = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));

        $tulos = $kysely->fetchObject();
        
        if ($tulos == null) {
            return null;
        } else {
            $tyontekija = new Tyontekija();
            $tyontekija->setTunnus($tulos->tunnus);
            $tyontekija->setSahkoposti($tulos->sahkoposti);
            $tyontekija->setNimi($tulos->nimi);
            $tyontekija->setJohtaja($tulos->johtaja);
            $tyontekija->setKuvaus($tulos->kuvaus);
            $tyontekija->setSalasana($tulos->salasana);
   
            return $tyontekija;
        }
    }
    
    public static function haePalveluntarjoajat($palvelu_id = 0) {
        if($palvelu_id != 0) {
            $sql = "SELECT tyontekija FROM palveluntarjoaja WHERE palvelu = ?";
        } else {
            $sql = "SELECT tunnus AS tyontekija FROM tyontekija";
        }
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($palvelu_id));
        
        $palveluntarjoajat = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $palveluntarjoajat[] = Tyontekija::haeTyontekija($tulos->tyontekija);
        }

        return $palveluntarjoajat;
    }
    
   

}
