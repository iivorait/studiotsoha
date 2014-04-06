<?php

class Palvelu {
    
    private $tunnus;
    private $nimi;
    private $hinta;
    private $kesto;
    private $kuvaus;
    private $virheet = array();

    public function getTunnus() {
        return $this->tunnus;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getHinta() {
        return $this->hinta;
    }

    public function getKesto() {
        return $this->kesto;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }
    
    public function getVirheet() {
        return $this->virheet;
    }

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
        
        if (trim($nimi) == '') {
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä.";
        } else {
            unset($this->virheet['nimi']);
        }
    }

    public function setHinta($hinta) {
        $this->hinta = $hinta;
        
        if (!is_numeric($hinta)) {
            $this->virheet['hinta'] = "Hinnan tulee olla numero.";
        } else if ($hinta <= 0) {
            $this->virheet['hinta'] = "Hinnan täytyy olla positiivinen.";
        } else {
            unset($this->virheet['hinta']);
        }
    }

    public function setKesto($kesto) {
        $this->kesto = $kesto;
        
        if (!is_numeric($kesto)) {
            $this->virheet['kesto'] = "Keston tulee olla numero.";
        } else if ($kesto <= 0) {
            $this->virheet['kesto'] = "Keston täytyy olla positiivinen.";
        } else if (!preg_match('/^\d+$/', $kesto)) {
            $this->virheet['kesto'] = "Keston tulee olla kokonaisluku.";
        } else {
            unset($this->virheet['kesto']);
        }
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
        
        if (trim($kuvaus) == '') {
            $this->virheet['kuvaus'] = "Kuvaus ei saa olla tyhjä.";
        } else {
            unset($this->virheet['kuvaus']);
        }
    }
    
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    public function lisaaKantaan() {
        $sql = "INSERT INTO palvelu (nimi, hinta, kesto, kuvaus) VALUES (?,?,?,?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->nimi, $this->hinta, $this->kesto, $this->kuvaus));
        
        return $ok;
    }
    
    public function paivitaKantaan() {
        $sql = "UPDATE palvelu SET nimi = ?, hinta = ?, kesto = ?, kuvaus = ? WHERE tunnus = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->nimi, $this->hinta, $this->kesto, $this->kuvaus, $this->tunnus));
        
        return $ok;
    }
    
    public static function haePalvelu($palvelu_id) {
        $sql = "SELECT * FROM palvelu WHERE tunnus = ?";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($palvelu_id));
        
        $tulos = $kysely->fetchObject();

        if ($tulos == null) {
            return null;
        } else {
            $palvelu = new Palvelu();
            $palvelu->setTunnus($tulos->tunnus);
            $palvelu->setNimi($tulos->nimi);
            $palvelu->setHinta($tulos->hinta);
            $palvelu->setKesto($tulos->kesto);
            $palvelu->setKuvaus($tulos->kuvaus);

            return $palvelu;
        }
    }

    public static function haePalvelut() {
        $sql = "SELECT * FROM palvelu ORDER BY nimi";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
        $palvelut = array();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $palvelut[] = Palvelu::haePalvelu($tulos->tunnus);
        }

        return $palvelut;

    }
   
    public static function poistaPalvelu($palvelu_id) {
        $sql = "DELETE FROM palvelu WHERE tunnus = ?";
        
        $kysely = getTietokantayhteys()->prepare($sql);
        return $kysely->execute(array($palvelu_id));
    }
}