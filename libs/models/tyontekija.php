<?php

class Tyontekija {
    
    private $tunnus;
    private $sahkoposti;
    private $nimi;
    private $johtaja;
    private $kuvaus;
    private $salasana;
    private $kalenteri;
    private $virheet = array();
    
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
    
    public function getKalenteri() {
        return $this->kalenteri;
    }
    
    public function getVirheet() {
        return $this->virheet;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setSahkoposti($sahkoposti) {
        if (trim($sahkoposti) == '') {
            $this->virheet['sahkoposti'] = "Sähköpostiosoite ei saa olla tyhjä.";
        } else if(filter_var($sahkoposti, FILTER_VALIDATE_EMAIL) != $sahkoposti) {
            $this->virheet['sahkoposti'] = "Sähköpostiosoite ei ole oikean muotoinen.";
        } else if(!Asiakas::onkoOsoiteVapaa($sahkoposti) && $this->sahkoposti!=$sahkoposti) {
            $this->virheet['sahkoposti'] = "Sähköpostiosoite on varattu.";
        } else {
            unset($this->virheet['sahkoposti']);
        }
        
        $this->sahkoposti = $sahkoposti;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
        
        if (trim($nimi) == '') {
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä.";
        } else {
            unset($this->virheet['nimi']);
        }
    }

    public function setJohtaja($johtaja) {
        $this->johtaja = $johtaja;
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
    }

    public function setSalasana($salasana) {
        $this->salasana = $salasana;
        
        if (trim($salasana) == '') {
            $this->virheet['salasana'] = "Salasana ei saa olla tyhjä.";
        } else {
            unset($this->virheet['salasana']);
        }
    }
    
    public function salasananTarkistus($salasana) {
        if (trim($salasana) == '') {
            $this->virheet['salasana'] = "Salasanan tarkistus ei saa olla tyhjä.";
            $this->salasana = '';
        } else if ($salasana != $this->salasana) {
            $this->virheet['salasana'] = "Salasanan tarkistus ei täsmännyt";
            $this->salasana = '';
        } else {
            unset($this->virheet['salasana']);
        }
    }
    
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    public function lataaKalenteri($paivamaara) {
        $sql = "SELECT aloitusaika, kesto FROM varaus WHERE tyontekija = ? AND paivamaara = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->tunnus, $paivamaara));
        
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
    
    public function lisaaKantaan() {
        $sql = "INSERT INTO tyontekija "
                . "(sahkoposti, nimi, johtaja, kuvaus, salasana) "
                . "VALUES (?,?,?,?,?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        
        $ok = $kysely->execute(array($this->sahkoposti, $this->nimi, $this->johtaja, 
            $this->kuvaus, md5($this->salasana . salasanaSuola)));
        
        $this->tunnus = getTietokantayhteys()->lastInsertId('tunnus');
        
        return $ok;
    }
    
    public function paivitaKantaan() {
        $sql = "SELECT salasana FROM tyontekija WHERE tunnus = ?";
        $salasananhakukysely = getTietokantayhteys()->prepare($sql);
        $salasananhakukysely->execute(array($this->tunnus));

        $tulos = $salasananhakukysely->fetchObject();
        $salasana = $tulos->salasana;
        
        $sql = "UPDATE tyontekija SET sahkoposti = ?, nimi = ?, johtaja = ?, "
                . "kuvaus = ?, salasana = ? WHERE tunnus = ?";
        
        if($salasana != $this->salasana) { //uuden salasanan asetus
            $salasana = md5($this->salasana . salasanaSuola);
        }
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->sahkoposti, $this->nimi, $this->johtaja,
            $this->kuvaus, $salasana, $this->tunnus));
        
        return $ok;
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
    
    public function haeKuukaudenVaraukset($kuukausi, $vuosi) {
        $sql = "SELECT tunnus FROM varaus WHERE tyontekija = ? AND paivamaara LIKE ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->tunnus, $vuosi . '-' . sprintf('%02d', $kuukausi) . '-%')); 
        
        $varaukset = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $varaukset[] = Varaus::haeVaraus($tulos->tunnus);
        }

        return $varaukset;
    }
    
    public function haeKuukaudenTyotunnit($kuukausi, $vuosi) {
        $sql = "SELECT paivamaara FROM tuntikirjaus WHERE tyontekija = ? AND paivamaara LIKE ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->tunnus, $vuosi . '-' . sprintf('%02d', $kuukausi) . '-%')); 
        
        $tuntikirjaukset = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tuntikirjaukset[] = Tuntikirjaus::haeTuntikirjaus($this->tunnus, $tulos->paivamaara);
        }

        return $tuntikirjaukset;
    }

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
    
    public static function haeTyontekijat() {
        $sql = "SELECT tunnus FROM tyontekija ORDER BY nimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
        $tyontekijat = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tyontekijat[] = Tyontekija::haeTyontekija($tulos->tunnus);
        }

        return $tyontekijat;
    }
    
    public static function poistaTyontekija($tyontekija_id) {
        $sql = "DELETE FROM tyontekija WHERE tunnus = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($tyontekija_id));
        
        if (file_exists("images/" . $tyontekija_id . ".jpg")) {
            unlink("images/" . $tyontekija_id . ".jpg");
        }
        
        return $ok;
    }

}
