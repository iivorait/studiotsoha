<?php

class Kayttaja {

    private $id;
    private $tunnus;
    private $salasana;

    public function __construct($id, $tunnus, $salasana) {
        $this->id = $id;
        $this->tunnus = $tunnus;
        $this->salasana = $salasana;
    }

    /* Tähän gettereitä ja settereitä */
    
    public function getId() {
        return $this->id;
    }

    public function getTunnus() {
        return $this->tunnus;
    }

        
    public static function getKayttajat() {
        $sql = "SELECT tunnus, sahkoposti, salasana FROM asiakas";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Kayttaja($tulos->tunnus, $tulos->sahkoposti, $tulos->salasana);

            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
    }
}