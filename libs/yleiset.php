<?php
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/asiakas.php';
require_once 'libs/models/tyontekija.php';
require_once 'libs/models/varaus.php';
require_once 'libs/models/palvelu.php';
require_once 'libs/models/asiakas.php';
require_once 'libs/models/palveluntarjoaja.php';
require_once 'libs/models/tuntikirjaus.php';
//Mallit täytyy ladata ennen istunnon aloittamista, jotta istuntoon tallennetut muuttujat deserialisoituvat oikein
session_start(); 

require_once 'libs/asetukset.php';

function naytaNakyma($sivu, $data = array()) {
    $data = (object)$data;
    require 'views/pohja.php';
    exit();
}

function onkoKirjautunut($ohjaus = 0) {
    if ($_SESSION['kirjautunut'] != null) {
        return true;
    } else {
        if($ohjaus) {
            naytaNakyma("etusivu.php", array(
                'kirjautumisvirhe' => "Sinun täytyy olla kirjautuneena sisään",
            ));
        } else {
            return false;
        }
    }
}

function tarkistaKayttooikeus($ohjaus = 0, $johtajavaatimus = 0) {
    if(get_class($_SESSION['kirjautunut'])=="Tyontekija" && $_SESSION['kirjautunut']->getJohtaja()
            || get_class($_SESSION['kirjautunut'])=="Tyontekija" && $johtajavaatimus == 0) {
        return true;
    } else {
        if($ohjaus) {
            naytaNakyma("etusivu.php", array(
                'virhe' => "Sinulla ei ole pääsyä tälle sivulle",
            ));
        } else {
            return false;
        }
    }
}

function onkoTyontekija() {
    return (get_class($_SESSION['kirjautunut'])=="Tyontekija");
}

function onkoJohtaja() {
    return $_SESSION['kirjautunut']->getJohtaja();
}

function onkoKantaasiakas($ohjaus = false) {
    if (!$_SESSION['kirjautunut']->getKantaasiakas() && $ohjaus) {
        naytaNakyma("etusivu.php", array(
            'virhe' => "Sinun täytyy olla kanta-asiakas, jotta voit muokata tietojasi.",
        ));
    }
    return $_SESSION['kirjautunut']->getKantaasiakas();
}

function getKirjautunutKayttaja() {
    return $_SESSION['kirjautunut'];
}

function setKirjautunutKayttaja($kayttaja) {
    $_SESSION['kirjautunut'] = $kayttaja;
}

function getTyoajat() {
    $tyoajat = array();

    for($tunti = tyoaikaAlkaa; $tunti < tyoaikaLoppuu; $tunti++) {
        for($minuutti = 00; $minuutti < 60; $minuutti += 15) {
            $tyoajat[] = array(
                'tunti' => $tunti, 
                'minuutti' => $minuutti
            );
        }
    }
    
    return $tyoajat;
}