<?php

function getTietokantayhteys() {
    static $yhteys = null; //Muuttuja, jonka sisältö säilyy getTietokantayhteys-kutsujen välillä.

    if ($yhteys === null) {
        //Tämä koodi suoritetaan vain kerran, sillä seuraavilla 
        //funktion suorituskerroilla $yhteys-muuttujassa on sisältöä.
        //Tietokannan tunnukset:
        require 'tietokantatunnukset.php';

        //Yhteysolion luominen
        $yhteys = new PDO("mysql:host=localhost;dbname=$tietokanta", $kayttajanimi, $salasana);

        //Seuravaa komento pyytää PDO:ta tuottamaan poikkeuksen aina kun jossain on virhe.
        //Kannattaa käyttää, oletuksena luokka ei raportoi virhetiloja juuri mitenkään!
        $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $yhteys;
}
