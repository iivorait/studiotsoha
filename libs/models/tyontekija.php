<?php

class Tyontekija {
    
    private $tunnus;
    private $sahkoposti;
    private $nimi;
    private $johtaja;
    private $kuvaus;
    private $salasana;
    
    /*function __construct($tunnus, $sahkoposti, $nimi, $johtaja, $kuvaus, $salasana) {
        $this->tunnus = $tunnus;
        $this->sahkoposti = $sahkoposti;
        $this->nimi = $nimi;
        $this->johtaja = $johtaja;
        $this->kuvaus = $kuvaus;
        $this->salasana = $salasana;
    } */
    
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

    /* Etsitään kannasta käyttäjätunnuksella ja salasanalla käyttäjäriviä */

    public static function etsiKayttajaTunnuksilla($sahkoposti, $salasana) {
        $sql = "SELECT * from tyontekija where sahkoposti = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti, $salasana));

        $tulos = $kysely->fetchObject();
        
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Tyontekija();
            $kayttaja->setTunnus($tulos->tunnus);
            $kayttaja->setSahkoposti($tulos->sahkoposti);
            $kayttaja->setNimi($tulos->nimi);
            $kayttaja->setJohtaja($tulos->johtaja);
            $kayttaja->setKuvaus($tulos->kuvaus);
            $kayttaja->setSalasana($tulos->salasana);
   
            return $kayttaja;
        }
    } 

}
