<?php

class Asiakas {

    private $tunnus;
    private $kantaasiakas;
    private $sahkoposti;
    private $etunimi;
    private $sukunimi;
    private $lahiosoite;
    private $postinumero;
    private $postitoimipaikka;
    private $puhelinnumero;
    private $salasana;
    private $virheet = array();

    public function getTunnus() {
        return $this->tunnus;
    }

    public function getKantaasiakas() {
        return $this->kantaasiakas;
    }

    public function getSahkoposti() {
        return $this->sahkoposti;
    }

    public function getEtunimi() {
        return $this->etunimi;
    }

    public function getSukunimi() {
        return $this->sukunimi;
    }

    public function getLahiosoite() {
        return $this->lahiosoite;
    }

    public function getPostinumero() {
        return $this->postinumero;
    }

    public function getPostitoimipaikka() {
        return $this->postitoimipaikka;
    }

    public function getPuhelinnumero() {
        return $this->puhelinnumero;
    }

    public function getSalasana() {
        return $this->salasana;
    }
    
    public function getVirheet() {
        return $this->virheet;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setKantaasiakas($kantaasiakas) {
        $this->kantaasiakas = $kantaasiakas;
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

    public function setEtunimi($etunimi) {
        $this->etunimi = $etunimi;
        
        if (trim($etunimi) == '') {
            $this->virheet['etunimi'] = "Etunimi ei saa olla tyhjä.";
        } else {
            unset($this->virheet['etunimi']);
        }
    }

    public function setSukunimi($sukunimi) {
        $this->sukunimi = $sukunimi;
        
        if (trim($sukunimi) == '') {
            $this->virheet['sukunimi'] = "Sukunimi ei saa olla tyhjä.";
        } else {
            unset($this->virheet['sukunimi']);
        }
    }

    public function setLahiosoite($lahiosoite) {
        $this->lahiosoite = $lahiosoite;
        
        if (trim($lahiosoite) == '') {
            $this->virheet['lahiosoite'] = "Lähiosoite ei saa olla tyhjä.";
        } else {
            unset($this->virheet['lahiosoite']);
        }
    }

    public function setPostinumero($postinumero) {
        $this->postinumero = $postinumero;
        
        if (!is_numeric($postinumero)) {
            $this->virheet['postinumero'] = "Postinumeron tulee olla numero.";
        } else if ($postinumero <= 0) {
            $this->virheet['postinumero'] = "Postinumeron täytyy olla positiivinen.";
        } else {
            unset($this->virheet['postinumero']);
        }
    }

    public function setPostitoimipaikka($postitoimipaikka) {
        $this->postitoimipaikka = $postitoimipaikka;
        
        if (trim($postitoimipaikka) == '') {
            $this->virheet['postitoimipaikka'] = "Postitoimipaikka ei saa olla tyhjä.";
        } else {
            unset($this->virheet['postitoimipaikka']);
        }
    }

    public function setPuhelinnumero($puhelinnumero) {
        $puhelinnumero = str_replace("+358","0", str_replace(" ","",$puhelinnumero));
        
        $this->puhelinnumero = $puhelinnumero;
        
        if (!is_numeric($puhelinnumero)) {
            $this->virheet['puhelinnumero'] = "Puhelinnumeron tulee olla numero.";
        } else if ($puhelinnumero <= 0) {
            $this->virheet['puhelinnumero'] = "Puhelinnumeron täytyy olla positiivinen.";
        } else {
            unset($this->virheet['puhelinnumero']);
        }
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
    
    public function lisaaKantaan() {
        $sql = "INSERT INTO asiakas "
                . "(kantaasiakas, sahkoposti, etunimi, sukunimi, lahiosoite, postinumero, postitoimipaikka, puhelinnumero, salasana) "
                . "VALUES (?,?,?,?,?,?,?,?,?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        
        $ok = $kysely->execute(array($this->kantaasiakas, $this->sahkoposti, $this->etunimi, 
            $this->sukunimi, $this->lahiosoite, $this->postinumero, $this->postitoimipaikka,
            $this->puhelinnumero, md5($this->salasana . salasanaSuola)));
        
        return $ok;
    }
    
    public function paivitaKantaan() {
        $sql = "SELECT salasana FROM asiakas WHERE tunnus = ?";
        $salasananhakukysely = getTietokantayhteys()->prepare($sql);
        $salasananhakukysely->execute(array($this->tunnus));

        $tulos = $salasananhakukysely->fetchObject();
        $salasana = $tulos->salasana;
        
        $sql = "UPDATE asiakas SET sahkoposti = ?, etunimi = ?, sukunimi = ?, "
                . "lahiosoite = ?, postinumero = ?, postitoimipaikka = ?, "
                . "puhelinnumero = ?, salasana = ? WHERE tunnus = ?";
        
        if($salasana != $this->salasana) { //uuden salasanan asetus
            $salasana = md5($this->salasana . salasanaSuola);
        }
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->sahkoposti, $this->etunimi, $this->sukunimi,
            $this->lahiosoite, $this->postinumero, $this->postitoimipaikka,
            $this->puhelinnumero, $salasana, $this->tunnus));
        
        return $ok;
    }
    
    public function haeTunnus() {
        $sql = "SELECT tunnus FROM asiakas WHERE sahkoposti = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->sahkoposti, md5($this->salasana . salasanaSuola)));

        $tulos = $kysely->fetchObject();
        
        $this->tunnus = $tulos->tunnus;
    }

    /* Etsitään kannasta käyttäjätunnuksella ja salasanalla käyttäjäriviä */

    public static function etsiKayttajaTunnuksilla($sahkoposti, $salasana) {
        $sql = "SELECT tunnus FROM asiakas WHERE sahkoposti = ? AND salasana = ? AND kantaasiakas = 1 LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti, md5($salasana . salasanaSuola)));

        $tulos = $kysely->fetchObject();
        
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = Asiakas::haeAsiakas($tulos->tunnus);
   
            return $kayttaja;
        }
    }
    
    public static function haeAsiakas($tunnus) {
        $sql = "SELECT * FROM asiakas WHERE tunnus = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tunnus));

        $tulos = $kysely->fetchObject();
        
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Asiakas();
            $kayttaja->setTunnus($tulos->tunnus);
            $kayttaja->setKantaasiakas($tulos->kantaasiakas);
            $kayttaja->setSahkoposti($tulos->sahkoposti);
            $kayttaja->setEtunimi($tulos->etunimi);
            $kayttaja->setSukunimi($tulos->sukunimi);
            $kayttaja->setLahiosoite($tulos->lahiosoite);
            $kayttaja->setPostinumero($tulos->postinumero);
            $kayttaja->setPostitoimipaikka($tulos->postitoimipaikka);
            $kayttaja->setPuhelinnumero($tulos->puhelinnumero);
            $kayttaja->setSalasana($tulos->salasana);
   
            return $kayttaja;
        }
    }
    
    public static function onkoOsoiteVapaa($sahkoposti) {
        $sql = "SELECT COUNT(1) AS asiakas, "
                . "(SELECT COUNT(1) FROM tyontekija WHERE sahkoposti = ?) AS tyontekija "
                . "FROM asiakas WHERE sahkoposti = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti, $sahkoposti));

        $tulos = $kysely->fetchObject();
        
        if($tulos->asiakas > 0 || $tulos->tyontekija > 0) {
            return false;
        }
        
        return true;
    }

    public static function haeKantaasiakkaat() {
        $sql = "SELECT tunnus FROM asiakas WHERE kantaasiakas = 1 ORDER BY etunimi, sukunimi";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
 
        $asiakkaat = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $asiakas = Asiakas::haeAsiakas($tulos->tunnus);

            $asiakkaat[] = $asiakas;
        }

        return $asiakkaat;
        
    }
}