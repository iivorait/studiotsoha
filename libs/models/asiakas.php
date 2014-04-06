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

    /*function __construct($tunnus, $kantaasiakas, $sahkoposti, $etunimi, $sukunimi, $lahiosoite, $postinumero, $postitoimipaikka, $puhelinnumero, $salasana) {
        $this->tunnus = $tunnus;
        $this->kantaasiakas = $kantaasiakas;
        $this->sahkoposti = $sahkoposti;
        $this->etunimi = $etunimi;
        $this->sukunimi = $sukunimi;
        $this->lahiosoite = $lahiosoite;
        $this->postinumero = $postinumero;
        $this->postitoimipaikka = $postitoimipaikka;
        $this->puhelinnumero = $puhelinnumero;
        $this->salasana = $salasana; 
    }*/


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

    public function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    public function setKantaasiakas($kantaasiakas) {
        $this->kantaasiakas = $kantaasiakas;
    }

    public function setSahkoposti($sahkoposti) {
        $this->sahkoposti = $sahkoposti;
    }

    public function setEtunimi($etunimi) {
        $this->etunimi = $etunimi;
    }

    public function setSukunimi($sukunimi) {
        $this->sukunimi = $sukunimi;
    }

    public function setLahiosoite($lahiosoite) {
        $this->lahiosoite = $lahiosoite;
    }

    public function setPostinumero($postinumero) {
        $this->postinumero = $postinumero;
    }

    public function setPostitoimipaikka($postitoimipaikka) {
        $this->postitoimipaikka = $postitoimipaikka;
    }

    public function setPuhelinnumero($puhelinnumero) {
        $this->puhelinnumero = $puhelinnumero;
    }

    public function setSalasana($salasana) {
        $this->salasana = $salasana;
    }

    /* Etsitään kannasta käyttäjätunnuksella ja salasanalla käyttäjäriviä */

    public static function etsiKayttajaTunnuksilla($sahkoposti, $salasana) {
        $sql = "SELECT * FROM asiakas WHERE sahkoposti = ? AND salasana = ? AND kantaasiakas = 1 LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti, $salasana));

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


}