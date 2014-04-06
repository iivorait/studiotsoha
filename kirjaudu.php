<?php

require_once 'libs/yleiset.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/asiakas.php';
require_once 'libs/models/tyontekija.php';

if (empty($_POST["email"])) {
    naytaNakyma("etusivu.php", array(
        'kirjautumisvirhe' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.",
    ));
}
$sahkoposti = $_POST["email"];

if (empty($_POST["password"])) {
    naytaNakyma("etusivu.php", array(
        'kayttaja' => $sahkoposti,
        'kirjautumisvirhe' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}
$salasana = $_POST["password"];

$kayttaja = Asiakas::etsiKayttajaTunnuksilla($sahkoposti, $salasana);

if($kayttaja == null) {
    $kayttaja = Tyontekija::etsiKayttajaTunnuksilla($sahkoposti, $salasana);
}

if ($kayttaja!=null) { //Tunnukset oikein
    $_SESSION['kirjautunut'] = $kayttaja;
    header('Location: etusivu.php');
} else { //Tunnukset väärin
    naytaNakyma("etusivu.php", array(
        'kayttaja' => $sahkoposti,
        'kirjautumisvirhe' => 'Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä'
    ));
}